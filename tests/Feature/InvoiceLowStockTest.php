<?php

use App\Models\Drug;
use App\Models\Frame;
use App\Models\Invo;
use App\Models\Lens;
use App\Models\User;

test('low or empty stock never blocks the invoice, and every item is deducted', function () {
    $user = User::factory()->create();
    Drug::create(['name' => 'Timolol', 'sn' => 1, 'price' => 2000, 'special_code' => 'X1', 'drug_type' => 'Test', 'quantity' => 1]);
    Lens::create(['name' => 'Single Vision', 'sn' => 1, 'price' => 15000, 'special_code' => 'X1', 'quantity' => 0]);
    Frame::create(['name' => 'Ray Frame', 'sn' => 1, 'price' => 30000, 'special_code' => 'X1', 'quantity' => 5]);

    $this->actingAs($user)
        ->post(route('invoice.save'), ['pid' => 'Test Patient', 'discount' => '0', 'inputs' => [
            ['name' => 'Timolol (Drug)', 'price' => '2000', 'qty' => '3'],
            ['name' => 'Single Vision (Lens)', 'price' => '15000', 'qty' => '2'],
            ['name' => 'Ray Frame (Frame)', 'price' => '30000', 'qty' => '1'],
        ]])
        ->assertSessionHasNoErrors()
        ->assertRedirect('/invoice');

    expect((float) Invo::sole()->amount)->toBe(66000.0)
        ->and(Drug::sole()->quantity)->toBe(-2)
        ->and(Lens::sole()->quantity)->toBe(-2)
        ->and(Frame::sole()->quantity)->toBe(4);
});

test('selling the last item in stock goes through and leaves zero', function () {
    $user = User::factory()->create();
    Drug::create(['name' => 'Timolol', 'sn' => 1, 'price' => 2000, 'special_code' => 'X1', 'drug_type' => 'Test', 'quantity' => 2]);

    $this->actingAs($user)
        ->post(route('invoice.save'), ['pid' => 'Test Patient', 'discount' => '0', 'inputs' => [
            ['name' => 'Timolol (Drug)', 'price' => '2000', 'qty' => '2'],
        ]])
        ->assertRedirect('/invoice');

    expect(Invo::count())->toBe(1)->and(Drug::sole()->quantity)->toBe(0);
});
