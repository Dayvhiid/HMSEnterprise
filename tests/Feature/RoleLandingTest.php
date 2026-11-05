<?php

use App\Models\User;

test('each role lands on its own home screen after login', function (string $role, string $home) {
    $user = User::factory()->create(['role' => $role]);

    $this->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect(route('dashboard', absolute: false));

    $this->get(route('dashboard'))->assertRedirect(route($home));
})->with([
    'admin' => ['admin', 'admin.dashboard'],
    'clinician' => ['user', 'doctors.index'],
    'front desk' => ['reception', 'pages.register'],
    'optician' => ['optician', 'optician.index'],
]);

test('an unknown role lands on the clinical home screen', function () {
    $user = User::factory()->create(['role' => 'something-else']);

    $this->actingAs($user)->get(route('dashboard'))->assertRedirect(route('doctors.index'));
});

test('the old placeholder dashboard is gone', function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->followingRedirects()
        ->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee('Click to Proceed');
});

test('main screens show the signed-in user, module links and log out', function (string $route) {
    $user = User::factory()->create(['role' => 'user', 'name' => 'Dr Ada']);

    $this->actingAs($user)->get(route($route))
        ->assertOk()
        ->assertSee('Dr Ada')
        ->assertSee('Clinician')
        ->assertSee('Log out')
        ->assertSee(route('logout'), false)
        ->assertSee(config('clinic.product_name'));
})->with(['doctors.index', 'optician.index', 'pages.register', 'admin.admin2', 'public.records']);

test('only admins see the Admin link in the top bar', function () {
    $adminLink = '>Admin</a>';

    $this->actingAs(User::factory()->create(['role' => 'user']))
        ->get(route('doctors.index'))->assertDontSee($adminLink, false);

    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->get(route('admin.dashboard'))->assertOk()->assertSee($adminLink, false);
});

test('log out from the top bar ends the session', function () {
    $this->actingAs(User::factory()->create())->post(route('logout'))->assertRedirect('/');

    $this->assertGuest();
});
