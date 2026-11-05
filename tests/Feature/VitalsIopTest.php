<?php

use App\Models\User;
use App\Models\Vital;

test('vitals form submits right eye CCT under the stored column name', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('doctors.vitals'))
        ->assertOk()
        ->assertSee('name="odccct"', false)
        ->assertDontSee('name="odcct"', false);
});

test('all four IOP readings are saved and shown on the vitals result page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('vitals.store'), [
        'patient_code' => '780/05/2026',
        'odccct' => '541um',
        'odnct' => '14mmHg',
        'oscct' => '552um',
        'osnct' => '16mmHg',
    ])->assertRedirect(route('vitals.get', ['query' => '780/05/2026']));

    $vital = Vital::where('patient_code', '780/05/2026')->sole();
    expect($vital->odccct)->toBe('541um')
        ->and($vital->odnct)->toBe('14mmHg')
        ->and($vital->oscct)->toBe('552um')
        ->and($vital->osnct)->toBe('16mmHg');

    // VitalsController::vitals() reads the raw $_GET superglobal, which the test client does not populate.
    $_GET['query'] = '780/05/2026';

    $this->actingAs($user)
        ->get(route('vitals.get', ['query' => '780/05/2026']))
        ->assertOk()
        ->assertSee('541um')
        ->assertSee('14mmHg')
        ->assertSee('552um')
        ->assertSee('16mmHg');
});
