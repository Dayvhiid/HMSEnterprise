<?php

use App\Models\Notification;
use App\Models\PatientInfo;
use App\Models\User;

function makePatient(): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill([
        'patient_id' => '413/07/2026',
        'first_name' => 'Ada',
        'last_name' => 'Obi',
        'date' => '1990-01-01',
        'gender' => 'female',
        'phone' => '08000000000',
        'email' => 'ada@example.com',
        'city' => 'Lagos',
        'state' => 'Lagos',
        'street' => '1 Main St',
        'occupation' => 'Teacher',
        'emergency_fullname' => 'Ben Obi',
        'emergency_relationship' => 'Brother',
        'emergency_phone' => '08000000001',
        'emergency_email' => 'ben@example.com',
    ])->save();

    return $patient;
}

test('checking in a returning patient notifies doctors', function () {
    $user = User::factory()->create(['name' => 'Front Desk Jane']);
    $patient = makePatient();

    $this->actingAs($user)
        ->post(route('patient.checkin', $patient->id))
        ->assertRedirect(route('patient.show', $patient->id))
        ->assertSessionHas('success');

    $notification = Notification::sole();
    expect($notification->message)->toBe(Notification::RETURNING_PATIENT)
        ->and($notification->pid)->toBe('413/07/2026')
        ->and($notification->patient_name)->toBe('Ada Obi')
        ->and($notification->added_by)->toBe('Front Desk Jane');
});

test('patient card shows the check-in button and confirmation', function () {
    $user = User::factory()->create();
    $patient = makePatient();

    $this->actingAs($user)
        ->get(route('patient.show', $patient->id))
        ->assertOk()
        ->assertSee('Check In (Returning Patient)')
        ->assertSee('Not checked in today');

    // Once checked in, the button is replaced by the check-in time so nobody tries again.
    $this->actingAs($user)
        ->followingRedirects()
        ->post(route('patient.checkin', $patient->id))
        ->assertOk()
        ->assertSee('Patient checked in. The doctors have been notified.')
        ->assertSee('Checked in today')
        ->assertDontSee('Check In (Returning Patient)');
});

test('a patient can only be checked in once per day', function () {
    $user = User::factory()->create();
    $patient = makePatient();

    $this->actingAs($user)->post(route('patient.checkin', $patient->id));
    $this->actingAs($user)
        ->post(route('patient.checkin', $patient->id))
        ->assertRedirect(route('patient.show', $patient->id))
        ->assertSessionHas('info');

    expect(Notification::count())->toBe(1);
});

test('guests cannot check patients in', function () {
    $patient = makePatient();

    $this->post(route('patient.checkin', $patient->id))->assertRedirect(route('login'));

    expect(Notification::count())->toBe(0);
});

test('doctor dashboard labels returning and new patients', function () {
    $user = User::factory()->create();
    Notification::create(['message' => Notification::RETURNING_PATIENT, 'patient_name' => 'Ada Obi', 'added_by' => 'x', 'pid' => '1/07/2026']);
    Notification::create(['message' => Notification::NEW_PATIENT, 'patient_name' => 'Chi Eze', 'added_by' => 'x', 'pid' => '2/07/2026']);

    $this->actingAs($user)
        ->get(route('doctors.index'))
        ->assertOk()
        ->assertSee('Returning Patient')
        ->assertSee('New Patient')
        ->assertSee('Patient Notifications');
});

test('new patient registration records who registered the patient', function () {
    $user = User::factory()->create(['name' => 'Front Desk Jane']);

    $this->actingAs($user)->post(route('pages.store'), [
        'pid' => '555/07/2026',
        'firstname' => 'Chi',
        'lastname' => 'Eze',
        'dob' => '1990-01-01',
        'radio' => 'male',
        'phone' => '08000000002',
        'email' => 'chi@example.com',
        'city' => 'Abuja',
        'state' => 'FCT',
        'occupation' => 'Engineer',
        'street' => '2 Main St',
        'efn' => 'Uche Eze',
        'erel' => 'Sister',
        'epn' => '08000000003',
        'ee' => 'uche@example.com',
    ])->assertRedirect(route('patient.show', PatientInfo::where('patient_id', '555/07/2026')->value('id')));

    expect(PatientInfo::where('patient_id', '555/07/2026')->exists())->toBeTrue();
    $notification = Notification::sole();
    expect($notification->message)->toBe(Notification::NEW_PATIENT)
        ->and($notification->added_by)->toBe('Front Desk Jane');
});
