<?php

use App\Models\PatientInfo;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['name' => 'Dr Bisi']);

    $this->patient = new PatientInfo();
    $this->patient->forceFill([
        'patient_id' => '414/07/2026',
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
});

test('patient card shows an empty summary box before one is written', function () {
    $this->actingAs($this->user)
        ->get(route('patient.show', $this->patient->id))
        ->assertOk()
        ->assertSee('Patient Summary')
        ->assertSee('No summary yet.')
        ->assertSee('name="summary"', false);
});

test('a summary can be saved and is shown on the card with who updated it', function () {
    $this->actingAs($this->user)
        ->put(route('patient.summary.update', $this->patient->id), [
            'summary' => "Glaucoma suspect.\nReview IOP in 3 months.",
        ])
        ->assertRedirect(route('patient.show', $this->patient->id));

    $patient = $this->patient->fresh();
    expect($patient->summary)->toBe("Glaucoma suspect.\nReview IOP in 3 months.")
        ->and($patient->summary_updated_by)->toBe('Dr Bisi')
        ->and($patient->summary_updated_at)->not->toBeNull();

    $this->actingAs($this->user)
        ->get(route('patient.show', $this->patient->id))
        ->assertOk()
        ->assertSee('Patient summary saved.')
        ->assertSee('Review IOP in 3 months.')
        ->assertSee('Last updated by Dr Bisi')
        ->assertDontSee('No summary yet.');
});

test('a summary can be edited later and cleared', function () {
    $this->actingAs($this->user)
        ->put(route('patient.summary.update', $this->patient->id), ['summary' => 'First note'])
        ->assertRedirect();

    $other = User::factory()->create(['name' => 'Nurse Tolu']);
    $this->actingAs($other)
        ->put(route('patient.summary.update', $this->patient->id), ['summary' => 'Updated note'])
        ->assertRedirect();

    expect($this->patient->fresh()->summary)->toBe('Updated note')
        ->and($this->patient->fresh()->summary_updated_by)->toBe('Nurse Tolu');

    $this->actingAs($other)
        ->put(route('patient.summary.update', $this->patient->id), ['summary' => ''])
        ->assertRedirect();

    expect($this->patient->fresh()->summary)->toBeNull();
});

test('saving a summary does not change any other patient details', function () {
    $before = $this->patient->fresh()->only(['first_name', 'last_name', 'phone', 'email', 'street', 'occupation', 'emergency_fullname', 'emergency_phone']);

    $this->actingAs($this->user)
        ->put(route('patient.summary.update', $this->patient->id), ['summary' => 'Note'])
        ->assertRedirect();

    expect($this->patient->fresh()->only(array_keys($before)))->toBe($before);
});

test('a summary longer than 5000 characters is rejected', function () {
    $this->actingAs($this->user)
        ->from(route('patient.show', $this->patient->id))
        ->put(route('patient.summary.update', $this->patient->id), ['summary' => str_repeat('a', 5001)])
        ->assertRedirect(route('patient.show', $this->patient->id))
        ->assertSessionHasErrors('summary');

    expect($this->patient->fresh()->summary)->toBeNull();
});

test('guests cannot save a summary', function () {
    $this->put(route('patient.summary.update', $this->patient->id), ['summary' => 'Note'])
        ->assertRedirect(route('login'));

    expect($this->patient->fresh()->summary)->toBeNull();
});
