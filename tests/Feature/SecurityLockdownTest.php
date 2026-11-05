<?php

use App\Models\Appointment;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

function staffUser(): User
{
    return User::factory()->create(['role' => 'user']);
}

function adminUser(): User
{
    return User::factory()->create(['role' => 'admin']);
}

test('guests are sent to login for pages that used to be public', function (string $method, string $uri) {
    $this->call($method, $uri)->assertRedirect(route('login'));
})->with([
    ['GET', '/inventory/store'],
    ['DELETE', '/inventory/1/delete'],
    ['GET', '/admin-entry'],
    ['GET', '/payment-index'],
    ['GET', '/client'],
    ['GET', '/lensesImport'],
    ['POST', '/lenses/import'],
    ['POST', '/import-users'],
    ['GET', '/sendsms'],
    ['GET', '/signup'],
    ['GET', '/doctors/signup/imp'],
]);

test('a guest cannot delete an inventory row', function () {
    $row = Inventory::create([
        'date' => '2026-11-01', 'new_stock' => '0', 'name' => 'Timolol',
        'patient_code' => 'P1', 'booklet_no' => 'B1', 'qty_in' => '5', 'qty_out' => '0', 'balance' => '5',
    ]);

    $this->delete(route('inventory.delete', $row->id));

    expect(Inventory::find($row->id))->not->toBeNull();
});

test('bulk imports and test tools are for admins only', function (string $method, string $uri) {
    $this->actingAs(staffUser())->call($method, $uri)->assertForbidden();
})->with([
    ['GET', '/lensesImport'],
    ['POST', '/lenses/import'],
    ['POST', '/import-users'],
    ['GET', '/sendsms'],
]);

test('an admin can open the lens import page', function () {
    $this->actingAs(adminUser())->get('/lensesImport')->assertOk();
});

test('signed-in staff can still use the inventory ledger', function () {
    $this->actingAs(staffUser())->get('/inventory/store')->assertOk();
});

test('the public booking page still works without logging in', function () {
    $this->get('/booking')->assertOk();
});

test('a complete public booking is saved', function () {
    $this->post(route('booking.store'), [
        'name' => 'Ada Obi',
        'date' => now()->addDay()->toDateString(),
        'time' => '10:30',
        'complaints' => 'Blurred vision',
        'phone' => '08012345678',
    ])->assertRedirect(route('pages.status'));

    $appointment = Appointment::sole();
    expect($appointment->name)->toBe('Ada Obi')
        ->and($appointment->phone_number)->toBe('2348012345678');
});

test('an incomplete booking is rejected with messages instead of crashing', function () {
    $this->from('/booking')->post(route('booking.store'), [
        'name' => 'Ada Obi',
        'date' => now()->subDay()->toDateString(),
        'time' => '10:30',
        'complaints' => '',
        'phone' => 'call me',
    ])->assertRedirect('/booking')
        ->assertSessionHasErrors(['date', 'complaints', 'phone']);

    expect(Appointment::count())->toBe(0);
});

test('the booking form shows validation messages', function () {
    $this->from('/booking')->post(route('booking.store'), []);

    $this->get('/booking')->assertSee('The name field is required.');
});

test('new case-file images go to private storage and are served only to signed-in staff', function () {
    Storage::fake('local');
    Storage::fake('public');
    $user = staffUser();

    $this->actingAs($user)->post(route('images.store'), [
        'title' => 'P-001',
        'image' => UploadedFile::fake()->create('fundus.jpg', 20, 'image/jpeg'),
    ])->assertRedirect();

    $image = Image::sole();
    Storage::disk('local')->assertExists($image->path);
    expect(Storage::disk('public')->allFiles())->toBe([]);

    $this->actingAs($user)->get(route('images.file', $image))->assertOk();

    auth()->logout();
    $this->get(route('images.file', $image))->assertRedirect(route('login'));
});

test('images uploaded before the change are still shown from the public disk', function () {
    Storage::fake('local');
    Storage::fake('public');
    Storage::disk('public')->put('images/old.jpg', 'old-bytes');
    $image = Image::create(['title' => 'P-002', 'path' => 'images/old.jpg', 'mime_type' => 'image/jpeg', 'size' => 9]);

    $response = $this->actingAs(staffUser())->get(route('images.file', $image))->assertOk();

    expect($response->streamedContent())->toBe('old-bytes');
});

test('the image list page points at the protected image route', function () {
    $image = Image::create(['title' => 'P-003', 'path' => 'images/x.jpg', 'mime_type' => 'image/jpeg', 'size' => 1]);

    $this->actingAs(staffUser())->get(route('images.index'))
        ->assertSee(route('images.file', $image), false)
        ->assertDontSee('storage/images/x.jpg', false);
});

test('sms says it is not set up when no credentials are configured', function () {
    config(['services.nigeriabulksms.username' => null, 'services.nigeriabulksms.password' => null]);
    Http::fake();

    $this->actingAs(staffUser())->get(route('NaijaSMS', ['phone' => '2348012345678', 'message' => 'Hello']))
        ->assertRedirect(route('doctors.status'))
        ->assertSessionHas('msg', fn ($msg) => str_contains($msg, 'not set up'));

    Http::assertNothingSent();
});

test('sms is reported as sent only when the provider confirms it', function () {
    config(['services.nigeriabulksms.username' => 'u', 'services.nigeriabulksms.password' => 'p']);
    Http::fake(['portal.nigeriabulksms.com/*' => Http::response(['status' => 'OK', 'price' => 2])]);

    $this->actingAs(staffUser())->get(route('NaijaSMS', ['phone' => '2348012345678', 'message' => 'Hello']))
        ->assertSessionHas('msg', 'Message sent to the patient successfully.');
});

test('a provider error is not shown as a sent message', function () {
    config(['services.nigeriabulksms.username' => 'u', 'services.nigeriabulksms.password' => 'p']);
    Http::fake(['portal.nigeriabulksms.com/*' => Http::response(['error' => 'Insufficient balance'])]);

    $this->actingAs(staffUser())->get(route('NaijaSMS', ['phone' => '2348012345678', 'message' => 'Hello']))
        ->assertSessionHas('msg', 'Message not sent: Insufficient balance');
});
