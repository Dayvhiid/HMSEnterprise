<?php

use App\Models\User;
use App\Models\Vital;

beforeEach(function () {
    $this->user = User::factory()->create();
});

function iopVitalsPage($test, string $patientCode)
{
    // VitalsController::vitals() reads the raw $_GET superglobal, which the test client does not populate.
    $_GET['query'] = $patientCode;

    return $test->actingAs($test->user)->get(route('vitals.get', ['query' => $patientCode]));
}

test('the IOP section has a date and time field with a Now button', function () {
    $this->actingAs($this->user)
        ->get(route('doctors.vitals'))
        ->assertOk()
        ->assertSee('Date &amp; time IOP was taken', false)
        ->assertSee('name="iop_taken_at"', false)
        ->assertSee('type="datetime-local"', false)
        ->assertSee('id="iop-now"', false);
});

test('the IOP time is saved and shown on the visit card', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '612/11/25',
        'odnct' => '14mmHg',
        'iop_taken_at' => '2026-11-04T10:15',
        'form_token' => 't1',
    ])->assertRedirect(route('doctors.status'));

    $vital = Vital::sole();
    expect($vital->iop_taken_at->format('Y-m-d H:i'))->toBe('2026-11-04 10:15');

    iopVitalsPage($this, '612/11/25')
        ->assertOk()
        ->assertSeeInOrder(['IOP taken:', 'name="iop_taken_at" type="datetime-local" value="2026-11-04T10:15"'], false);
});

test('the IOP time is optional and shows a dash when not recorded', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '612/11/25', 'odnct' => '14mmHg', 'form_token' => 't1'])
        ->assertRedirect(route('doctors.status'));

    expect(Vital::sole()->iop_taken_at)->toBeNull();

    iopVitalsPage($this, '612/11/25')->assertSeeInOrder(['IOP taken:', 'name="iop_taken_at" type="datetime-local" value=""'], false);
});

test('the IOP time is pre-filled when editing and can be changed', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '612/11/25', 'odnct' => '14mmHg', 'iop_taken_at' => '2026-11-04T10:15', 'form_token' => 't1',
    ]);
    $vital = Vital::sole();

    $this->actingAs($this->user)
        ->get(route('vitals.edit', $vital))
        ->assertSee('value="2026-11-04T10:15"', false);

    $this->actingAs($this->user)
        ->put(route('vitals.update', $vital), ['odnct' => '14mmHg', 'iop_taken_at' => '2026-11-04T11:40'])
        ->assertRedirect();

    expect($vital->fresh()->iop_taken_at->format('Y-m-d H:i'))->toBe('2026-11-04 11:40');
});

test('an invalid IOP time is rejected and nothing is saved', function () {
    $this->actingAs($this->user)
        ->from(route('doctors.vitals'))
        ->post(route('vitals.store'), ['patient_code' => '612/11/25', 'iop_taken_at' => 'yesterday-ish', 'form_token' => 't1'])
        ->assertRedirect(route('doctors.vitals'))
        ->assertSessionHasErrors('iop_taken_at');

    expect(Vital::count())->toBe(0);
});
