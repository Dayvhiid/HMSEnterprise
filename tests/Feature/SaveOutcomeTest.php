<?php

use App\Models\PatientInfo;
use App\Models\Treat;
use App\Models\User;

function outcomePatient(string $pid = '800/11/2026'): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill([
        'patient_id' => $pid, 'first_name' => 'Ngozi', 'last_name' => 'Ade', 'date' => '1985-02-02',
        'gender' => 'female', 'phone' => '08000000010', 'email' => 'ngozi@example.com', 'city' => 'Ibadan',
        'state' => 'Oyo', 'street' => '3 Main St', 'occupation' => 'Trader', 'emergency_fullname' => 'Tola Ade',
        'emergency_relationship' => 'Sister', 'emergency_phone' => '08000000011', 'emergency_email' => 't@example.com',
    ])->save();

    return $patient;
}

test('the result page is branded, has no history-back button and shows the message', function () {
    $this->actingAs(User::factory()->create())
        ->withSession(['success' => 'Drug list updated.'])
        ->get(route('pages.status'))
        ->assertOk()
        ->assertSee('Drug list updated.')
        ->assertSee(config('clinic.product_name'))
        ->assertDontSee('<title>Document</title>', false)
        ->assertDontSee('history.go(-1)', false)
        ->assertSee('Home');
});

test('failures are shown as not completed', function () {
    $this->actingAs(User::factory()->create())
        ->withSession(['msg' => 'Message not sent: Insufficient balance', 'status_type' => 'error'])
        ->get(route('doctors.status'))
        ->assertSee('Not completed')
        ->assertSee('Message not sent: Insufficient balance');
});

test('saving a treatment plan opens the patient treatment history with a confirmation', function () {
    outcomePatient();

    $this->actingAs(User::factory()->create())
        ->post(route('treatment.store'), ['patient_id' => '800/11/2026', 'duration' => '1 Week', 'remark' => 'Review'])
        ->assertRedirect(route('search.get', ['query' => '800/11/2026']));

    expect(Treat::where('patient_id', '800/11/2026')->count())->toBe(1);

    $this->get(route('search.get', ['query' => '800/11/2026']))->assertSee('Treatment plan and prescription saved.');
});

test('a treatment for an unknown patient ID is rejected with a clear message', function () {
    $this->actingAs(User::factory()->create())
        ->from(route('doctors.treatment'))
        ->post(route('treatment.store'), ['patient_id' => 'NOPE', 'duration' => '1 Week'])
        ->assertRedirect(route('doctors.treatment'))
        ->assertSessionHasErrors(['patient_id' => 'No patient has that Patient ID. Check the ID on the patient card.']);

    expect(Treat::count())->toBe(0);
    $this->get(route('doctors.treatment'))->assertSee('No patient has that Patient ID.');
});

test('a duplicate patient ID at registration is explained on the form', function () {
    outcomePatient('801/11/2026');

    $this->actingAs(User::factory()->create())
        ->from(route('pages.register'))
        ->post(route('pages.store'), ['pid' => '801/11/2026', 'firstname' => 'A', 'lastname' => 'B', 'dob' => '1990-01-01',
            'radio' => 'male', 'phone' => '0800', 'email' => 'a@example.com'])
        ->assertSessionHasErrors('pid');

    $this->get(route('pages.register'))->assertSee('Please fix the following');
});

test('only admins can permanently delete a patient', function () {
    $patient = outcomePatient('802/11/2026');

    $this->actingAs(User::factory()->create(['role' => 'user']))
        ->delete(route('pages.delete', $patient->id))->assertForbidden();
    expect(PatientInfo::find($patient->id))->not->toBeNull();

    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->delete(route('pages.delete', $patient->id))
        ->assertRedirect(route('pages.status'))
        ->assertSessionHas('success', 'Patient record deleted.');
    expect(PatientInfo::find($patient->id))->toBeNull();
});

test('updating a patient that does not exist gives not found instead of a crash', function () {
    $this->actingAs(User::factory()->create())
        ->put(route('pages.update', 999999), [
            'first_name' => 'A', 'last_name' => 'B', 'gender' => 'male', 'phone' => '1', 'email' => 'a@b.c',
            'state' => 'Lagos', 'occupation' => 'X', 'emergency_phone' => '2',
        ])->assertNotFound();
});
