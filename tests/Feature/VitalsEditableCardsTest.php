<?php

use App\Models\User;
use App\Models\Vital;

beforeEach(function () {
    $this->user = User::factory()->create();
});

function editableCardsPage($test, string $patientCode)
{
    // VitalsController::vitals() reads the raw $_GET superglobal, which the test client does not populate.
    $_GET['query'] = $patientCode;

    return $test->actingAs($test->user)->get(route('vitals.get', ['query' => $patientCode]));
}

test('every visit card is its own form with the saved values in editable fields', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '780/05/2026',
        'cc' => 'Blurry vision',
        'ODSPH' => '-1.00',
        'ADDSPH' => '+2.00',
        'arpd' => '62',
        'srosph' => '-1.50',
        'iop_taken_at' => '2026-11-04T10:15',
        'form_token' => 't1',
    ]);
    $vital = Vital::sole();

    $response = editableCardsPage($this, '780/05/2026')->assertOk();
    $html = $response->getContent();

    expect(substr_count($html, '<form method="POST" action="'.route('vitals.update', $vital).'"'))->toBe(1);
    $response
        ->assertSee('Save changes to this visit')
        ->assertSee('name="cc"', false)
        ->assertSee('Blurry vision')
        ->assertSee('name="ODSPH" value="-1.00"', false)
        ->assertSee('name="ADDSPH" value="+2.00"', false)
        ->assertSee('name="arpd" type="number" step="any" min="40" max="85" value="62"', false)
        ->assertSee('name="srosph" value="-1.50"', false)
        ->assertSee('name="iop_taken_at" type="datetime-local" value="2026-11-04T10:15"', false)
        ->assertSee("event.key !== 'Enter'", false)
        ->assertSee('beforeunload', false);

    // Near VA and the lensometry axis are separate fields, each with exactly one input.
    expect(substr_count($html, 'name="ODAXIS"'))->toBe(1)
        ->and(substr_count($html, 'name="OSAXIS"'))->toBe(1);
});

test('saving a card updates that visit, including left-eye values, without creating a new one', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '780/05/2026', 'cc' => 'Old', 'srosph' => '-1.50', 'form_token' => 't1']);
    $vital = Vital::sole();

    $this->actingAs($this->user)
        ->from(route('vitals.get', ['query' => '780/05/2026']))
        ->put(route('vitals.update', $vital), ['cc' => 'New complaint', 'srosph' => '-1.75', 'ADDSPH' => '+2.25'])
        ->assertRedirect(route('vitals.get', ['query' => '780/05/2026']))
        ->assertSessionHas('success');

    expect(Vital::count())->toBe(1);
    $vital->refresh();
    expect($vital->cc)->toBe('New complaint')
        ->and($vital->addsph)->toBe('+2.25')
        ->and($vital->pairedVital2()->srosphere)->toBe('-1.75');
});

test('fields that a form does not send are left unchanged', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '780/05/2026', 'cc' => 'Keep me', 'ODunaided' => '6/9', 'fossph' => '-0.50', 'form_token' => 't1',
    ]);
    $vital = Vital::sole();

    $this->actingAs($this->user)->put(route('vitals.update', $vital), ['pohx' => 'Glasses since 2019']);

    $vital->refresh();
    expect($vital->pohx)->toBe('Glasses since 2019')
        ->and($vital->cc)->toBe('Keep me')
        ->and($vital->odunaided)->toBe('6/9')
        ->and($vital->pairedVital2()->fossph)->toBe('-0.50');
});

test('a field cleared on the card is saved as empty', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '780/05/2026', 'cc' => 'Remove me', 'form_token' => 't1']);
    $vital = Vital::sole();

    $this->actingAs($this->user)->put(route('vitals.update', $vital), ['cc' => '']);

    expect($vital->fresh()->cc)->toBeNull();
});

test('Near VA is saved on its own, separate from the lensometry axis', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '780/05/2026', 'ODnearVA' => 'N6', 'OSnearVA' => 'N8', 'ODAXIS' => '90', 'OSAXIS' => '180', 'form_token' => 't1',
    ]);
    $vital = Vital::sole();

    expect($vital->odaxis)->toBe('N6')
        ->and($vital->osaxis)->toBe('N8')
        ->and($vital->lodaxis)->toBe('90')
        ->and($vital->losaxis)->toBe('180');

    editableCardsPage($this, '780/05/2026')
        ->assertSee('name="ODnearVA" value="N6"', false)
        ->assertSee('name="OSnearVA" value="N8"', false)
        ->assertSee('name="ODAXIS" value="90"', false)
        ->assertSee('name="OSAXIS" value="180"', false);

    $this->actingAs($this->user)->get(route('vitals.edit', $vital))
        ->assertSee('name="ODnearVA" value="N6"', false)
        ->assertSee('name="ODAXIS" value="90"', false);
});

test('Near VA can be edited on the card without touching the axis', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '780/05/2026', 'ODnearVA' => 'N6', 'ODAXIS' => '90', 'form_token' => 't1']);
    $vital = Vital::sole();

    $this->actingAs($this->user)->put(route('vitals.update', $vital), ['ODnearVA' => 'N5', 'ODAXIS' => '90']);

    expect($vital->fresh()->odaxis)->toBe('N5')->and($vital->fresh()->lodaxis)->toBe('90');
});

test('Near VA counts as Visual Acuity taken, but an old copy of the axis does not', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '780/05/2026', 'ODnearVA' => 'N6', 'form_token' => 't1']);
    expect(Vital::sole()->examSectionsTaken()['Visual Acuity'])->toBeTrue();

    // A visit saved before the fix: Near VA columns hold a copy of the lensometry axis.
    $old = Vital::create(['patient_code' => '781/05/2026', 'odaxis' => '90', 'lodaxis' => '90', 'osaxis' => '180', 'losaxis' => '180']);
    expect($old->examSectionsTaken()['Visual Acuity'])->toBeFalse()
        ->and($old->examSectionsTaken()['Lensometry'])->toBeTrue();
});
