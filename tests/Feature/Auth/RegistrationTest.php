<?php

use App\Models\User;

// Public self-registration is disabled: staff accounts are created by an administrator.

test('registration screen is not available', function () {
    $this->get('/register')->assertNotFound();
});

test('nobody can create an account by posting to register', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    expect(User::where('email', 'test@example.com')->exists())->toBeFalse();
});
