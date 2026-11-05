<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('the staff page lists real accounts instead of mockup rows', function () {
    $admin = User::factory()->create(['role' => 'admin', 'name' => 'Grace Admin']);
    User::factory()->create(['role' => 'optician', 'name' => 'Femi Optician', 'email' => 'femi@clinic.test']);

    $this->actingAs($admin)->get(route('admin.staff'))
        ->assertOk()
        ->assertSee('Femi Optician')
        ->assertSee('femi@clinic.test')
        ->assertSee('Optician')
        ->assertSee('2 staff accounts')
        ->assertDontSee('Acme Health');
});

test('an admin can add a staff member who can then sign in to their own home screen', function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->post(route('admin.staff.store'), [
            'name' => 'Bisi Front', 'email' => 'bisi@clinic.test', 'role' => 'reception',
            'password' => 'Temp-pass-123', 'password_confirmation' => 'Temp-pass-123',
        ])
        ->assertRedirect(route('admin.staff'))
        ->assertSessionHas('success', 'Bisi Front was added as Front Desk.');

    $user = User::where('email', 'bisi@clinic.test')->sole();
    expect($user->role)->toBe('reception')
        ->and(Hash::check('Temp-pass-123', $user->password))->toBeTrue();

    auth()->logout();
    $this->post('/login', ['email' => 'bisi@clinic.test', 'password' => 'Temp-pass-123']);
    $this->get(route('dashboard'))->assertRedirect(route('pages.register'));
});

test('staff details are validated', function () {
    User::factory()->create(['email' => 'taken@clinic.test']);

    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->post(route('admin.staff.store'), [
            'name' => '', 'email' => 'taken@clinic.test', 'role' => 'superuser',
            'password' => 'short', 'password_confirmation' => 'different',
        ])
        ->assertSessionHasErrors(['name', 'role', 'password', 'email' => 'A staff member already uses that email address.']);
});

test('non-admins cannot see or add staff', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)->get(route('admin.staff'))->assertForbidden();
    $this->actingAs($user)->post(route('admin.staff.store'), [
        'name' => 'Sneaky', 'email' => 'sneaky@clinic.test', 'role' => 'admin',
        'password' => 'Temp-pass-123', 'password_confirmation' => 'Temp-pass-123',
    ])->assertForbidden();

    expect(User::where('email', 'sneaky@clinic.test')->exists())->toBeFalse();
});

test('telemedicine is hidden from the clinical dashboard unless switched on', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('doctors.index'))->assertDontSee('Telemedicine Module');

    config(['clinic.features.telemedicine' => true]);
    $this->actingAs($user)->get(route('doctors.index'))->assertSee('Telemedicine Module');
});
