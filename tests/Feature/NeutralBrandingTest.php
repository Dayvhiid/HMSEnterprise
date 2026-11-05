<?php

use App\Models\User;

test('the homepage is the neutral welcome page with booking and staff sign in', function () {
    config(['clinic.name' => 'Riverside Eye Centre']);

    $this->get('/')
        ->assertOk()
        ->assertSee('Welcome to Riverside Eye Centre')
        ->assertSee(route('booking'), false)
        ->assertSee(route('login'), false)
        ->assertDontSee('Ola-Oluwa')
        ->assertDontSee('Ola-oluwa');
});

test('the old marketing page address goes to the homepage', function () {
    $this->get('/landing-page')->assertRedirect('/');
});

test('staff screens show no other clinic or mockup names', function (string $route) {
    $html = $this->actingAs(User::factory()->create(['role' => 'admin']))->get(route($route))->assertOk()->getContent();

    expect($html)->not->toMatch('/ola[ -]?oluwa|Acme Health|Stitch Design|MediCare|<title>Document<\/title>/i');
})->with(['doctors.index', 'optician.index', 'pages.register', 'admin.dashboard', 'admin.admin2', 'admin.staff',
    'generate.show', 'invoice.find', 'public.records', 'optician.list', 'doctors.treatment', 'doctors.vitals']);

test('the clinic name on screens comes from configuration', function () {
    config(['clinic.short_name' => 'Riverside', 'clinic.product_name' => 'Riverside EMR']);

    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->get(route('admin.admin2'))
        ->assertSee('Riverside')
        ->assertSee('<title>Riverside EMR</title>', false);
});
