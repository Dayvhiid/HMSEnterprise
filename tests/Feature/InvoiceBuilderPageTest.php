<?php

use App\Models\Drug;
use App\Models\Invo;
use App\Models\PatientInfo;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

function billingPatient(): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill(['patient_id' => '430/11/2026', 'first_name' => 'Uche', 'last_name' => 'Nnadi', 'phone' => '08012345678', 'gender' => 'male'])->save();

    return $patient;
}

test('the invoice page is a clean billing workspace with no CDN assets or stray code', function () {
    $html = $this->actingAs($this->user)->get(route('generate.show'))
        ->assertOk()
        ->assertSee('data-zone="workspace"', false)
        ->assertSee('Invoice items')
        ->assertSee('Payment summary')
        ->assertSee('Generate invoice')
        ->assertSee('href="'.route('invoice.find').'"', false)
        ->assertDontSee('Enter name to search for invoice')
        ->assertDontSee('cdn.jsdelivr.net', false)
        ->assertDontSee('code.jquery.com', false)
        ->getContent();

    expect($html)->not->toMatch('#//\s*</script>#')
        ->and($html)->not->toMatch('#//\s*<script>#');
});

test('the form still posts the fields the save action reads', function () {
    $this->actingAs($this->user)->get(route('generate.show'))
        ->assertSee('action="'.route('invoice.save').'"', false)
        ->assertSee('name="pid"', false)
        ->assertSee('name="discount"', false)
        // Lines added in the browser use the same field names.
        ->assertSee("name=\"inputs[' + i + '][name]\"", false)
        ->assertSee("name=\"inputs[' + i + '][price]\"", false)
        ->assertSee("name=\"inputs[' + i + '][qty]\"", false);
});

test('opening billing from the chart fills in the patient and shows who it is', function () {
    billingPatient();

    $this->actingAs($this->user)->get(route('generate.show', ['patient' => '430/11/2026']))
        ->assertSee('name="pid" value="430/11/2026"', false)
        ->assertSee('Uche Nnadi')
        ->assertSee('08012345678');
});

test('the patient chart links to billing for that patient', function () {
    $patient = billingPatient();

    $this->actingAs($this->user)->get(route('patient.show', $patient->id))
        ->assertSee(route('generate.show', ['patient' => '430/11/2026']), false)
        ->assertSee('Create invoice');
});

test('an invoice saved from the new page reduces stock and opens the receipt with the patient', function () {
    billingPatient();
    $drug = Drug::create(['name' => 'Timolol', 'price' => '1500', 'quantity' => 10, 'drug_type' => 'Drops']);

    $response = $this->actingAs($this->user)->post(route('invoice.save'), [
        'pid' => '430/11/2026', 'discount' => '10',
        'inputs' => [['name' => 'Timolol (Drug)', 'price' => '1500', 'qty' => '2']],
    ]);
    $invoice = Invo::sole();
    $response->assertRedirect(route('invoice.show', ['id' => $invoice->id]));

    expect((float) $invoice->amount)->toBe(2700.0)
        ->and($drug->fresh()->quantity)->toBe(8);

    $this->get(route('invoice.show', ['id' => $invoice->id]))->assertSee('Patient: Uche Nnadi');
});

test('a failed save keeps the lines, patient and discount', function () {
    $this->actingAs($this->user)->from(route('generate.show'))->post(route('invoice.save'), [
        'pid' => 'Walk-in Ada', 'discount' => '150',
        'inputs' => [['name' => 'Timolol (Drug)', 'price' => '1500', 'qty' => '2']],
    ])->assertRedirect(route('generate.show'));

    $this->get(route('generate.show'))
        ->assertSee('name="pid" value="Walk-in Ada"', false)
        ->assertSee('name="inputs[0][name]" value="Timolol (Drug)"', false)
        ->assertSee('name="inputs[0][qty]" value="2"', false)
        ->assertSee('value="150"', false)
        ->assertSee('Discount is a percentage and must be between 0 and 100.');
});
