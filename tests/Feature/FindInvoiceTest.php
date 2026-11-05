<?php

use App\Models\Invo;
use App\Models\PatientInfo;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

function invoiceFor(string $pid, array $lines, int $discount = 0, ?string $at = null): Invo
{
    $invoice = new Invo();
    $invoice->pid = $pid;
    $invoice->discount = $discount;
    $invoice->name = array_column($lines, 0);
    $invoice->price = array_column($lines, 1);
    $invoice->qty = array_column($lines, 2);
    $invoice->amount = 0;
    $invoice->save();
    if ($at) {
        $invoice->forceFill(['created_at' => $at])->save();
    }

    return $invoice;
}

function findPatient(): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill(['patient_id' => '440/11/2026', 'first_name' => 'Zainab', 'last_name' => 'Musa', 'gender' => 'female'])->save();

    return $patient;
}

test('find invoice is a list on the clinical layout with tabs and no old search page', function () {
    invoiceFor('Walk-in Ada', [['Timolol (Drug)', 1500, 2]]);

    $this->actingAs($this->user)->get(route('invoice.find'))
        ->assertOk()
        ->assertSee('data-zone="workspace"', false)
        ->assertSee('aria-current="page"', false)
        ->assertSee('RCT-000001')
        ->assertSee('Walk-in Ada')
        ->assertSee('2 × Timolol (Drug)')
        ->assertSee('₦3,000.00')
        ->assertSee(route('invoice.show', ['id' => 1]), false)
        ->assertDontSee('cdn.jsdelivr.net', false);
});

test('an invoice made by picking a patient is found by name, by Patient ID and shows the patient', function () {
    $patient = findPatient();
    invoiceFor('440/11/2026', [['Frame A (Frame)', 20000, 1]]);
    invoiceFor('Someone Else', [['Lens B (Lens)', 5000, 1]]);

    foreach (['zainab musa', 'musa', '440/11/2026'] as $q) {
        $this->actingAs($this->user)->get(route('invoice.find', ['query' => $q]))
            ->assertSee('Zainab Musa')
            ->assertSee(route('patient.show', $patient->id), false)
            ->assertDontSee('Someone Else');
    }
});

test('a receipt number finds that invoice', function (string $q) {
    invoiceFor('First', [['A (Service)', 100, 1]]);
    invoiceFor('Second', [['B (Service)', 100, 1]]);

    $this->actingAs($this->user)->get(route('invoice.find', ['query' => $q]))
        ->assertSee('Second')->assertDontSee('>First<', false);
})->with(['RCT-000002', 'rct000002', '2']);

test('the old search URL shows the same list', function () {
    invoiceFor('Walk-in Ada', [['Timolol (Drug)', 1500, 1]]);

    $this->actingAs($this->user)->get(route('invoice.search', ['query' => 'ada']))
        ->assertOk()->assertSee('Walk-in Ada')->assertSee('id="invoice-filters"', false);
});

test('date presets and ranges filter the list and the summary uses receipt maths', function () {
    invoiceFor('Today Patient', [['A (Service)', 1000, 2]], 10);
    invoiceFor('Old Patient', [['B (Service)', 5000, 1]], 0, now()->subDays(40)->toDateTimeString());

    $this->actingAs($this->user)->get(route('invoice.find', ['period' => 'today']))
        ->assertSee('Today Patient')->assertDontSee('Old Patient')
        ->assertSeeInOrder(['Invoices', '1', 'Total billed', '₦1,800.00', 'Discounts given', '₦200.00'])
        ->assertSee('value="'.today()->toDateString().'"', false);

    $this->actingAs($this->user)->get(route('invoice.find', ['to' => now()->subDays(30)->toDateString()]))
        ->assertSee('Old Patient')->assertDontSee('Today Patient');
});

test('the patient chart links to that patient\'s invoices', function () {
    $patient = findPatient();

    $this->actingAs($this->user)->get(route('patient.show', $patient->id))
        ->assertSee(route('invoice.find', ['query' => '440/11/2026']), false);
});

test('an empty search explains what to try', function () {
    $this->actingAs($this->user)->get(route('invoice.find', ['query' => 'nobody']))
        ->assertSee('No invoices match these filters.');
});
