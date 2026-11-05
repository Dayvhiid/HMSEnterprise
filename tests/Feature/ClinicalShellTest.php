<?php

use App\Models\User;

test('every main screen has the universal search in the top bar', function (string $route) {
    $this->actingAs(User::factory()->create(['role' => 'user']))
        ->get(route($route))
        ->assertOk()
        ->assertSee('role="search"', false)
        ->assertSee('action="'.route('search.global').'"', false)
        ->assertSee('Search patient name, ID, phone or screen');
})->with(['doctors.index', 'optician.index', 'pages.register', 'admin.admin2', 'public.records']);

test('a non-live copy is labelled in the top bar', function () {
    config(['clinic.environment' => ['is_live' => false, 'label' => 'DEMO - not live patient data']]);

    $this->actingAs(User::factory()->create())
        ->get(route('doctors.index'))
        ->assertOk()
        ->assertSee('data-environment="DEMO - not live patient data"', false);
});

test('the live system shows no environment banner', function () {
    config(['clinic.environment' => ['is_live' => true, 'label' => 'LIVE']]);

    $this->actingAs(User::factory()->create())
        ->get(route('doctors.index'))
        ->assertOk()
        ->assertDontSee('data-environment=', false);
});

test('clinical layout screens load locally built styles, not a CDN', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('search.global', ['q' => 'ada']))
        ->assertOk()
        ->assertSee('/build/assets/clinical-', false)
        ->assertDontSee('cdn.tailwindcss.com', false)
        ->assertDontSee('cdn.jsdelivr.net', false);
});

test('the environment label derives from APP_ENV unless set explicitly', function () {
    $config = require config_path('clinic.php');

    // phpunit.xml runs with APP_ENV=testing.
    expect($config['environment']['is_live'])->toBeFalse()
        ->and($config['environment']['label'])->toBe('TESTING - not live patient data');
});

test('the clinical home has no Case Files link in its menu', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('doctors.index'))
        ->assertOk()
        ->assertDontSee('>Case Files<', false)
        ->assertDontSee(route('images.search'), false);
});
