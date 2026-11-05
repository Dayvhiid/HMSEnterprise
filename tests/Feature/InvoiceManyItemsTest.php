<?php

use App\Models\Invo;
use App\Models\User;

test('an invoice with more than five items is saved with every item', function (int $count) {
    $user = User::factory()->create();

    $inputs = [];
    for ($i = 0; $i < $count; $i++) {
        $inputs[$i] = ['name' => "Item {$i} (Service)", 'price' => '1000', 'qty' => '1'];
    }

    $this->actingAs($user)
        ->from(route('generate.show'))
        ->post(route('invoice.save'), ['pid' => 'Test Patient', 'discount' => '0', 'inputs' => $inputs])
        ->assertSessionHasNoErrors()
        ->assertRedirectContains('/invoice?id=');

    $invoice = Invo::sole();
    expect($invoice->name)->toHaveCount($count)
        ->and((float) $invoice->amount)->toBe(1000.0 * $count);
})->with([5, 6, 10]);

test('a completely empty extra row does not block the invoice', function () {
    $user = User::factory()->create();

    $inputs = [];
    for ($i = 0; $i < 6; $i++) {
        $inputs[$i] = ['name' => "Item {$i} (Service)", 'price' => '500', 'qty' => '2'];
    }
    $inputs[6] = ['name' => '', 'price' => '', 'qty' => ''];

    $this->actingAs($user)
        ->post(route('invoice.save'), ['pid' => 'Test Patient', 'discount' => '10', 'inputs' => $inputs])
        ->assertSessionHasNoErrors()
        ->assertRedirectContains('/invoice?id=');

    $invoice = Invo::sole();
    expect($invoice->name)->toHaveCount(6)
        ->and((float) $invoice->amount)->toBe(5400.0);
});

test('a bad row shows which row failed and keeps every row the user typed', function () {
    $user = User::factory()->create();

    $inputs = [];
    for ($i = 0; $i < 5; $i++) {
        $inputs[$i] = ['name' => "Item {$i} (Service)", 'price' => '1000', 'qty' => '1'];
    }
    $inputs[5] = ['name' => 'Item 5 (Lens)', 'price' => '15,000', 'qty' => '1'];

    $this->actingAs($user)
        ->from(route('generate.show'))
        ->post(route('invoice.save'), ['pid' => 'Test Patient', 'discount' => '0', 'inputs' => $inputs])
        ->assertRedirect(route('generate.show'))
        ->assertSessionHasErrors('inputs.5.price');

    expect(Invo::count())->toBe(0);

    $this->actingAs($user)
        ->get(route('generate.show'))
        ->assertOk()
        ->assertSee('The invoice was not saved.')
        ->assertSee('Row 6: price must be a number (no commas or currency signs).')
        ->assertSee('value="Test Patient"', false)
        ->assertSee('name="inputs[5][name]"', false)
        ->assertSee('value="Item 5 (Lens)"', false)
        ->assertSee('value="15,000"', false)
        ->assertSee('var rowCounter = 5;', false);
});
