<?php

use App\Models\Notification;
use App\Models\PatientInfo;
use App\Models\User;
use App\Models\Vital;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'reception']);
});

function listPatient(array $attributes): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill($attributes + ['gender' => 'female', 'phone' => '08000000000'])->save();

    return $patient;
}

function patientsList($test, array $query = [])
{
    return $test->actingAs($test->user)->get(route('public.records', $query));
}

test('the patients list is a table on the clinical layout with no public-website links', function () {
    $patient = listPatient(['patient_id' => '1/11/2026', 'first_name' => 'Ada', 'last_name' => 'Obi', 'date' => '1990-05-01']);

    patientsList($this)
        ->assertOk()
        ->assertSee('data-zone="workspace"', false)
        ->assertSee('Ada Obi')
        ->assertSee('1/11/2026')
        ->assertSee('01-May-1990')
        ->assertSee(route('patient.show', $patient->id), false)
        ->assertSee(route('patient.edit', $patient->id), false)
        ->assertSee('Showing <strong>1</strong>–<strong>1</strong> of <strong>1</strong> patient', false)
        ->assertDontSee('>About<', false)
        ->assertDontSee('>Contact<', false)
        ->assertDontSee('cdn.tailwindcss.com', false);
});

test('search matches name words, patient ID and phone digits, like the top-bar search', function (string $query) {
    listPatient(['patient_id' => '2/11/2026', 'first_name' => 'Chidi', 'last_name' => 'Eze', 'phone' => '0803 555 1234']);
    listPatient(['patient_id' => '3/11/2026', 'first_name' => 'Bola', 'last_name' => 'Ade', 'phone' => '0809 999 0000']);

    patientsList($this, ['query' => $query])->assertSee('Chidi Eze')->assertDontSee('Bola Ade');
})->with(['chidi eze', 'eze', '2/11/2026', '5551234']);

test('the old search URL still works', function () {
    listPatient(['patient_id' => '4/11/2026', 'first_name' => 'Ngozi', 'last_name' => 'Okafor']);

    $this->actingAs($this->user)->get(route('records.search', ['query' => 'ngozi']))
        ->assertOk()->assertSee('Ngozi Okafor');
});

test('filters by sex, check-in today and registration date', function () {
    listPatient(['patient_id' => '5/11/2026', 'first_name' => 'Femi', 'last_name' => 'Male', 'gender' => 'Male']);
    $her = listPatient(['patient_id' => '6/11/2026', 'first_name' => 'Kemi', 'last_name' => 'Female', 'gender' => 'female']);
    Notification::create(['patient_name' => 'Kemi Female', 'message' => Notification::RETURNING_PATIENT, 'added_by' => 'x', 'pid' => '6/11/2026']);

    patientsList($this, ['sex' => 'male'])->assertSee('Femi Male')->assertDontSee('Kemi Female');
    patientsList($this, ['checked_in' => 1])->assertSee('Kemi Female')->assertDontSee('Femi Male');
    patientsList($this, ['from' => now()->addDay()->toDateString()])->assertSee('No patients match these filters.');
    patientsList($this)->assertSeeInOrder(['Kemi Female', 'Checked in']);
});

test('shows the date of the last exam', function () {
    listPatient(['patient_id' => '7/11/2026', 'first_name' => 'Tayo', 'last_name' => 'Bello']);
    Vital::create(['patient_code' => '7/11/2026'])->forceFill(['created_at' => '2026-10-30 09:00:00'])->save();

    patientsList($this)->assertSeeInOrder(['Tayo Bello', '30-Oct-2026']);
});

test('pages through long lists 25 at a time', function () {
    foreach (range(1, 30) as $n) {
        listPatient(['patient_id' => "{$n}/01/2026", 'first_name' => 'P'.$n, 'last_name' => 'Test']);
    }

    patientsList($this)->assertSee('of <strong>30</strong> patients', false)->assertSee('page=2', false);
    patientsList($this, ['page' => 2])->assertSee('Showing <strong>26</strong>–<strong>30</strong>', false);
});

test('an empty search result offers to register the patient', function () {
    patientsList($this, ['query' => 'nobody'])
        ->assertSee('No patients match these filters.')
        ->assertSee(route('pages.register'), false);
});
