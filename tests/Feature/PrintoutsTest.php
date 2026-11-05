<?php

use App\Models\Invo;
use App\Models\PatientInfo;
use App\Models\User;
use App\Models\Vital;
use App\Models\vital2;

function printPatient(string $pid): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill([
        'patient_id' => $pid, 'first_name' => 'Kemi', 'last_name' => 'Bello', 'date' => now()->subYears(40)->toDateString(),
        'gender' => 'female', 'phone' => '08000000020', 'email' => 'kemi@example.com', 'city' => 'Lagos', 'state' => 'Lagos',
        'street' => '4 Main St', 'occupation' => 'Banker', 'emergency_fullname' => 'Tayo Bello', 'emergency_relationship' => 'Husband',
        'emergency_phone' => '08000000021', 'emergency_email' => 'tayo@example.com',
    ])->save();

    return $patient;
}

test('saving an invoice opens the receipt for that invoice, not just the newest one', function () {
    printPatient('P-100');
    $this->actingAs(User::factory()->create());

    $this->post(route('invoice.save'), ['pid' => 'P-100', 'discount' => '10', 'inputs' => [
        ['name' => 'Frame A (Service)', 'price' => '5000', 'qty' => '2'],
    ]]);
    $first = Invo::sole();
    // Another cashier saves an invoice afterwards.
    $this->post(route('invoice.save'), ['pid' => 'P-200', 'discount' => '0', 'inputs' => [
        ['name' => 'Eye test (Service)', 'price' => '3000', 'qty' => '1'],
    ]]);

    $this->get(route('invoice.show', ['id' => $first->id]))
        ->assertOk()
        ->assertSee($first->receiptNumber())
        ->assertSee('P-100')
        ->assertSee('Kemi Bello')
        ->assertSee('₦10,000.00')   // subtotal
        ->assertSee('-₦1,000.00')   // 10% discount
        ->assertSee('₦9,000.00')    // total
        ->assertSee(config('clinic.name'))
        ->assertDontSee('P-200');
});

test('the receipt page with no invoices yet sends you to create one', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('invoice.show'))
        ->assertRedirect(route('generate.show'));
});

test('a receipt for an unknown invoice is not found', function () {
    $this->actingAs(User::factory()->create())->get(route('invoice.show', ['id' => 999]))->assertNotFound();
});

test('the spectacle prescription prints the final rx for both eyes with the letterhead', function () {
    printPatient('P-300');
    $vital = Vital::create(['patient_code' => 'P-300', 'fodsph' => '-1.25', 'fodcyl' => '-0.50', 'fodaxis' => '180', 'fodva' => '6/6', 'fodadd' => '+1.50', 'arpd' => '62']);
    vital2::create(['patient_code' => 'P-300', 'fossph' => '-1.00', 'foscyl' => '-0.75', 'fosaxis' => '175', 'fosva' => '6/6']);

    $this->actingAs(User::factory()->create())
        ->get(route('vitals.prescription', $vital))
        ->assertOk()
        ->assertSee('Spectacle prescription')
        ->assertSee(config('clinic.name'))
        ->assertSee('Kemi Bello')
        ->assertSeeInOrder(['OD (Right)', '-1.25', '-0.50', '180', '6/6', '+1.50'])
        ->assertSeeInOrder(['OS (Left)', '-1.00', '-0.75', '175'])
        ->assertSee('62 mm')
        ->assertSee('Signature');
});

test('a visit with no final rx says so instead of printing an empty prescription', function () {
    $vital = Vital::create(['patient_code' => 'P-301', 'cc' => 'Headache']);

    $this->actingAs(User::factory()->create())
        ->get(route('vitals.prescription', $vital))
        ->assertOk()
        ->assertSee('No final prescription (Final RX) was recorded for this visit.');
});

test('each visit card links to its printable prescription', function () {
    $vital = Vital::create(['patient_code' => 'P-302', 'fodsph' => '-2.00']);

    $this->actingAs(User::factory()->create())
        ->get(route('vitals.get', ['query' => 'P-302']))
        ->assertSee(route('vitals.prescription', $vital), false)
        ->assertSee('Print spectacle Rx');
});

test('guests cannot open a prescription or a receipt', function () {
    $vital = Vital::create(['patient_code' => 'P-303']);

    $this->get(route('vitals.prescription', $vital))->assertRedirect(route('login'));
    $this->get(route('invoice.show'))->assertRedirect(route('login'));
});
