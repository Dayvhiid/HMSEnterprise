<?php

use App\Models\PatientInfo;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'reception']);
});

function existingPatient(string $pid): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill(['patient_id' => $pid, 'first_name' => 'Ada', 'last_name' => 'Obi', 'gender' => 'female', 'phone' => '0801'])->save();

    return $patient;
}

test('the registration page uses the clinical layout with one navigation bar', function () {
    $this->actingAs($this->user)->get(route('pages.register'))
        ->assertOk()
        ->assertSee('data-zone="workspace"', false)
        ->assertSee('data-zone="action-bar"', false)
        ->assertSee('Personal information')
        ->assertSee('Contact &amp; address', false)
        ->assertSee('Emergency contact')
        ->assertSee('Register Patient')
        ->assertDontSee('Admin 2')
        ->assertDontSee('Opticianry')
        ->assertDontSee('cdn.tailwindcss.com', false)
        ->assertDontSee('fonts.googleapis.com', false);
});

test('the form keeps the original field names', function () {
    $response = $this->actingAs($this->user)->get(route('pages.register'));

    foreach (['firstname', 'lastname', 'dob', 'radio', 'phone', 'email', 'street', 'city', 'state', 'occupation', 'efn', 'erel', 'epn', 'ee', 'pid'] as $name) {
        $response->assertSee('name="'.$name.'"', false);
    }
});

test('a failed save keeps what was typed and suggests a new patient ID when the ID was taken', function () {
    existingPatient('5/11/2026');

    $this->actingAs($this->user)->from(route('pages.register'))->post(route('pages.store'), [
        'pid' => '5/11/2026', 'firstname' => 'Chidi', 'lastname' => 'Eze', 'dob' => '1990-01-01', 'radio' => 'male',
        'phone' => '08055555555', 'email' => 'chidi@example.com', 'city' => 'Enugu',
    ])->assertRedirect(route('pages.register'));

    $this->get(route('pages.register'))
        ->assertSee('value="Chidi"', false)
        ->assertSee('value="08055555555"', false)
        ->assertSee('value="Enugu"', false)
        ->assertSee('<option value="male" selected', false)
        ->assertSee('A new ID has been suggested.')
        ->assertDontSee('name="pid" value="5/11/2026"', false);
});

test('today\'s registrations are listed with links to their cards', function () {
    $patient = existingPatient('7/11/2026');

    $this->actingAs($this->user)->get(route('pages.register'))
        ->assertSee('Registered today')
        ->assertSee('Ada Obi')
        ->assertSee(route('patient.show', $patient->id), false);
});

test('the environment label is a badge inside the top bar', function () {
    config(['clinic.environment' => ['is_live' => false, 'label' => 'LOCAL - not live patient data']]);

    $html = $this->actingAs($this->user)->get(route('pages.register'))->getContent();

    expect(strpos($html, 'class="sb-bar"'))->toBeLessThan(strpos($html, 'data-environment="LOCAL - not live patient data"'));
});
