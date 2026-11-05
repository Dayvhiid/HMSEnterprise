<?php

use App\Models\Invo;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// Discount on an invoice is a percentage of its subtotal. Reports must apply it the same way.

function saveInvoice($test, string $pid, int $discount, array $inputs)
{
    return $test->post(route('invoice.save'), ['pid' => $pid, 'discount' => (string) $discount, 'inputs' => $inputs]);
}

function seedTwoInvoices($test): void
{
    $test->actingAs(User::factory()->create(['role' => 'admin']));
    // 2 x 5,000 + 1 x 2,000 = 12,000 gross, 10% off = 1,200 discount, 10,800 net
    saveInvoice($test, 'P-1', 10, [
        ['name' => 'Frame A (Service)', 'price' => '5000', 'qty' => '2'],
        ['name' => 'Eye test (Service)', 'price' => '2000', 'qty' => '1'],
    ])->assertSessionHasNoErrors();
    // 3,000 gross, no discount
    saveInvoice($test, 'P-2', 0, [
        ['name' => 'Eye test (Service)', 'price' => '3000', 'qty' => '1'],
    ])->assertSessionHasNoErrors();
}

test('invoice totals apply the discount as a percentage', function () {
    seedTwoInvoices($this);

    $invoice = Invo::where('pid', 'P-1')->sole();
    expect($invoice->totals())->toBe(['gross' => 12000.0, 'discount' => 1200.0, 'net' => 10800.0])
        ->and((float) $invoice->amount)->toBe(10800.0);
});

test('the invoice analytics page shows net revenue, discounts given and gross sales', function () {
    seedTwoInvoices($this);

    $this->get(route('admin.invoice.analytics'))
        ->assertOk()
        ->assertSee('Net revenue (after discounts)')
        ->assertSee('₦13,800')       // 10,800 + 3,000
        ->assertSee('₦1,200')        // discount in naira, not "10"
        ->assertSee('₦15,000');      // gross sales
});

test('the invoices api reports net revenue and no longer crashes', function () {
    seedTwoInvoices($this);

    $this->getJson('/invoices-api')
        ->assertOk()
        ->assertJsonPath('count', 2)
        ->assertJsonPath('total_revenue', 13800)
        ->assertJsonFragment(['pid' => 'P-1', 'discount_amount' => 1200, 'total_after_discount' => 10800]);
});

test('old comma-separated invoice rows are still counted', function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']));
    DB::table('invos')->insert([
        'pid' => 'OLD-1', 'name' => 'Lens A,Lens B', 'price' => '1000,2000', 'qty' => '1,2',
        'discount' => 0, 'amount' => 5000, 'created_at' => now(), 'updated_at' => now(),
    ]);

    expect(Invo::sole()->totals()['net'])->toBe(5000.0);
    $this->getJson('/invoices-api')->assertJsonPath('total_revenue', 5000);
});

test('a discount above 100 percent is rejected', function () {
    $this->actingAs(User::factory()->create());

    saveInvoice($this, 'P-3', 150, [['name' => 'Eye test (Service)', 'price' => '3000', 'qty' => '1']])
        ->assertSessionHasErrors(['discount' => 'Discount is a percentage and must be between 0 and 100.']);

    expect(Invo::count())->toBe(0);
});
