<?php

use App\Models\User;
use App\Models\Vital;

test('vitals form shows the auto-refraction P.D. input', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('doctors.vitals'))
        ->assertOk()
        ->assertSee('name="arpd"', false)
        ->assertSee('P.D. (Pupillary Distance, mm)');
});

test('auto-refraction P.D. is saved and shown on the vitals result page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('vitals.store'), [
        'patient_code' => '781/05/2026',
        'arodsph' => '-1.25',
        'arpd' => '62.5',
    ])->assertRedirect(route('doctors.status'));

    $vital = Vital::where('patient_code', '781/05/2026')->sole();
    expect($vital->arpd)->toBe('62.5')
        ->and($vital->arodsphere)->toBe('-1.25');

    // VitalsController::vitals() reads the raw $_GET superglobal, which the test client does not populate.
    $_GET['query'] = '781/05/2026';

    $this->actingAs($user)
        ->get(route('vitals.get', ['query' => '781/05/2026']))
        ->assertOk()
        ->assertSee('P.D. (Pupillary Distance):')
        ->assertSee('name="arpd" type="number" step="any" min="40" max="85" value="62.5"', false);
});

test('vitals can be saved without a P.D.', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('vitals.store'), [
        'patient_code' => '782/05/2026',
    ])->assertRedirect(route('doctors.status'));

    expect(Vital::where('patient_code', '782/05/2026')->sole()->arpd)->toBeNull();
});

test('an invalid P.D. is rejected and nothing is saved', function (string $pd) {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('doctors.vitals'))
        ->post(route('vitals.store'), [
            'patient_code' => '783/05/2026',
            'arpd' => $pd,
        ])
        ->assertRedirect(route('doctors.vitals'))
        ->assertSessionHasErrors('arpd');

    expect(Vital::where('patient_code', '783/05/2026')->exists())->toBeFalse();
})->with(['62mm', '20', '120']);
