<?php

use App\Models\PatientInfo;
use App\Models\User;

function searchablePatient(array $overrides = []): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill(array_merge([
        'patient_id' => '413/07/2026',
        'first_name' => 'Ada',
        'last_name' => 'Obi',
        'date' => '1990-01-01',
        'gender' => 'female',
        'phone' => '08031234567',
        'email' => 'ada@example.com',
        'city' => 'Lagos',
        'state' => 'Lagos',
        'street' => '1 Main St',
        'occupation' => 'Teacher',
        'emergency_fullname' => 'Ben Obi',
        'emergency_relationship' => 'Brother',
        'emergency_phone' => '08000000001',
        'emergency_email' => 'ben@example.com',
    ], $overrides))->save();

    return $patient;
}

function searchJson(User $user, string $q)
{
    return test()->actingAs($user)->getJson(route('search.global', ['q' => $q]));
}

test('guests cannot search', function () {
    $this->get(route('search.global', ['q' => 'ada']))->assertRedirect(route('login'));
    $this->getJson(route('search.global', ['q' => 'ada']))->assertUnauthorized();
});

test('patients are found by name, full name, patient ID and phone', function (string $q) {
    $ada = searchablePatient();
    searchablePatient(['patient_id' => '999/01/2025', 'first_name' => 'Chidi', 'last_name' => 'Eze', 'phone' => '07000000000']);

    searchJson(User::factory()->create(), $q)
        ->assertOk()
        ->assertJsonCount(1, 'patients')
        ->assertJsonPath('patients.0.name', 'Ada Obi')
        ->assertJsonPath('patients.0.patient_id', '413/07/2026')
        ->assertJsonPath('patients.0.url', route('patient.show', $ada->id));
})->with([
    'first name' => ['ada'],
    'first and last name' => ['Ada Obi'],
    'last name then first' => ['obi ada'],
    'patient ID' => ['413/07'],
    'phone with spaces' => ['0803 123 4567'],
]);

test('patients registered with only a full name are found and named', function () {
    searchablePatient(['first_name' => '', 'last_name' => '', 'fullname' => 'Ngozi Okafor']);

    searchJson(User::factory()->create(), 'ngozi')
        ->assertJsonCount(1, 'patients')
        ->assertJsonPath('patients.0.name', 'Ngozi Okafor');
});

test('a query shorter than two characters returns nothing', function () {
    searchablePatient();

    searchJson(User::factory()->create(), 'a')
        ->assertOk()
        ->assertExactJson(['patients' => [], 'actions' => []]);
});

test('screens are found by name or keyword', function () {
    searchJson(User::factory()->create(), 'invoice')
        ->assertOk()
        ->assertJsonFragment(['label' => 'Generate invoice', 'url' => route('generate.show')]);
});

test('admin screens only appear in search for admins', function () {
    searchJson(User::factory()->create(['role' => 'user']), 'staff')
        ->assertJsonMissing(['label' => 'Staff']);

    searchJson(User::factory()->create(['role' => 'admin']), 'staff')
        ->assertJsonFragment(['label' => 'Staff', 'url' => route('admin.staff')]);
});

test('the results page lists matching patients with a link to their chart', function () {
    $ada = searchablePatient();

    $this->actingAs(User::factory()->create())
        ->get(route('search.global', ['q' => 'obi']))
        ->assertOk()
        ->assertSee('Ada Obi')
        ->assertSee('413/07/2026')
        ->assertSee(route('patient.show', $ada->id), false)
        ->assertSee('data-zone="workspace"', false);
});

test('the results page offers registration when nobody matches', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('search.global', ['q' => 'nobody-here']))
        ->assertOk()
        ->assertSee('No patient matches')
        ->assertSee(route('pages.register'), false);
});

test('patient names are escaped on the results page', function () {
    searchablePatient(['first_name' => '<script>alert(1)</script>', 'last_name' => 'Obi']);

    $this->actingAs(User::factory()->create())
        ->get(route('search.global', ['q' => 'obi']))
        ->assertOk()
        ->assertDontSee('<script>alert(1)</script>', false)
        ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
});
