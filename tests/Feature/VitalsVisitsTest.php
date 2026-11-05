<?php

use App\Models\User;
use App\Models\Vital;
use App\Models\vital2;

beforeEach(function () {
    $this->user = User::factory()->create();
});

function vitalsResultPage($test, string $patientCode)
{
    // VitalsController::vitals() reads the raw $_GET superglobal, which the test client does not populate.
    $_GET['query'] = $patientCode;

    return $test->actingAs($test->user)->get(route('vitals.get', ['query' => $patientCode]));
}

// --- A. Accidental and duplicate saves ---

test('the vitals form has a one-time token, an Enter-key guard and a Save button that locks', function () {
    $this->actingAs($this->user)
        ->get(route('doctors.vitals'))
        ->assertOk()
        ->assertSee('name="form_token"', false)
        ->assertSee("event.key !== 'Enter'", false)
        ->assertSee('id="vitals-save"', false)
        ->assertSee('saveButton.disabled = true', false);
});

test('submitting the same form twice saves the exam only once', function () {
    $form = ['patient_code' => '612/11/25', 'cc' => 'Blurry vision', 'fossph' => '-0.75', 'form_token' => 'token-abc'];

    $this->actingAs($this->user)->post(route('vitals.store'), $form)
        ->assertRedirect(route('vitals.get', ['query' => '612/11/25']));

    // Same form again: double click, or Back button then Save.
    $this->actingAs($this->user)->post(route('vitals.store'), $form)
        ->assertRedirect(route('vitals.get', ['query' => '612/11/25']))
        ->assertSessionHas('info');

    expect(Vital::where('patient_code', '612/11/25')->count())->toBe(1)
        ->and(vital2::where('patient_code', '612/11/25')->count())->toBe(1);
});

test('two different forms for the same patient are both saved', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '612/11/25', 'cc' => 'First', 'form_token' => 'token-1']);
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '612/11/25', 'cc' => 'Second', 'form_token' => 'token-2']);

    expect(Vital::where('patient_code', '612/11/25')->count())->toBe(2);
});

test('a form without a patient ID is rejected with a message and keeps what was typed', function () {
    $this->actingAs($this->user)
        ->from(route('doctors.vitals'))
        ->post(route('vitals.store'), ['patient_code' => '', 'cc' => 'Itchy eyes', 'ODunaided' => '6/9', 'form_token' => 'token-x'])
        ->assertRedirect(route('doctors.vitals'))
        ->assertSessionHasErrors('patient_code');

    expect(Vital::count())->toBe(0);

    $this->actingAs($this->user)
        ->get(route('doctors.vitals'))
        ->assertSee('Enter the Patient ID before saving.')
        ->assertSee('Itchy eyes')
        ->assertSee('value="6/9"', false)
        ->assertSee('value="token-x"', false);

    // The token of a rejected form was never used, so fixing the error and saving works.
    $this->actingAs($this->user)
        ->post(route('vitals.store'), ['patient_code' => '700/01/2026', 'cc' => 'Itchy eyes', 'form_token' => 'token-x'])
        ->assertRedirect(route('vitals.get', ['query' => '700/01/2026']));
    expect(Vital::where('patient_code', '700/01/2026')->count())->toBe(1);
});

// --- B. One card per visit ---

test('each visit is its own card, newest first, with its own left-eye values', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '612/11/25', 'cc' => 'First visit', 'srosph' => '-1.50', 'fossph' => '-1.25', 'form_token' => 't1',
    ]);
    $this->travel(3)->days();
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '612/11/25', 'cc' => 'Second visit', 'srosph' => '-2.50', 'fossph' => '-2.25', 'form_token' => 't2',
    ]);

    [$older, $newer] = Vital::where('patient_code', '612/11/25')->orderBy('id')->get()->all();

    vitalsResultPage($this, '612/11/25')
        ->assertOk()
        ->assertSee('2 visits, newest first')
        ->assertSeeInOrder([
            'Visit: '.$newer->created_at->format('F j, Y g:i A'), 'Second visit', '-2.50', '-2.25',
            'Visit: '.$older->created_at->format('F j, Y g:i A'), 'First visit', '-1.50', '-1.25',
        ])
        ->assertSee(route('vitals.edit', $newer), false)
        ->assertSee(route('vitals.edit', $older), false);
});

test('a patient with no vitals sees an empty message', function () {
    vitalsResultPage($this, '999/99/99')
        ->assertOk()
        ->assertSee('No vitals recorded for this patient.');
});

// --- C. Editing a visit ---

test('the edit form opens pre-filled with that visit, including left-eye values', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '612/11/25', 'cc' => 'Headache', 'ODunaided' => '6/12', 'arpd' => '63', 'fossph' => '-0.50', 'form_token' => 't1',
    ]);
    $vital = Vital::sole();

    $this->actingAs($this->user)
        ->get(route('vitals.edit', $vital))
        ->assertOk()
        ->assertSee('Editing the visit of')
        ->assertSee('Headache')
        ->assertSee('value="6/12"', false)
        ->assertSee('value="63"', false)
        ->assertSee('value="-0.50"', false)
        ->assertSee('Save Changes')
        ->assertDontSee('name="form_token"', false);
});

test('saving an edit updates that visit instead of creating a new one', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '612/11/25', 'cc' => 'Headache', 'ODunaided' => '6/12', 'fossph' => '-0.50', 'form_token' => 't1',
    ]);
    $vital = Vital::sole();
    $this->travel(1)->hours();

    $this->actingAs($this->user)
        ->put(route('vitals.update', $vital), [
            'patient_code' => 'SOMEONE-ELSE', // ignored: a visit can't be moved to another patient
            'cc' => 'Headache, worse at night', 'ODunaided' => '6/9', 'fossph' => '-0.75',
        ])
        ->assertRedirect(route('vitals.get', ['query' => '612/11/25']))
        ->assertSessionHas('success');

    expect(Vital::count())->toBe(1)->and(vital2::count())->toBe(1);
    $vital->refresh();
    expect($vital->cc)->toBe('Headache, worse at night')
        ->and($vital->odunaided)->toBe('6/9')
        ->and($vital->patient_code)->toBe('612/11/25')
        ->and($vital->pairedVital2()->fossph)->toBe('-0.75');

    vitalsResultPage($this, '612/11/25')
        ->assertSee('Headache, worse at night')
        ->assertSee('Edited on '.$vital->updated_at->format('F j, Y g:i A'));
});

test('editing one visit leaves the patient\'s other visits unchanged', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '612/11/25', 'cc' => 'Visit one', 'fossph' => '-1.00', 'form_token' => 't1']);
    $this->travel(1)->days();
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '612/11/25', 'cc' => 'Visit two', 'fossph' => '-2.00', 'form_token' => 't2']);
    [$first, $second] = Vital::orderBy('id')->get()->all();

    $this->actingAs($this->user)->put(route('vitals.update', $second), ['cc' => 'Visit two edited', 'fossph' => '-2.50']);

    expect($first->fresh()->cc)->toBe('Visit one')
        ->and($first->fresh()->pairedVital2()->fossph)->toBe('-1.00')
        ->and($second->fresh()->cc)->toBe('Visit two edited')
        ->and($second->fresh()->pairedVital2()->fossph)->toBe('-2.50');
});

test('guests cannot open or save the edit form', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '612/11/25', 'cc' => 'Note', 'form_token' => 't1']);
    $vital = Vital::sole();
    auth()->logout();

    $this->get(route('vitals.edit', $vital))->assertRedirect(route('login'));
    $this->put(route('vitals.update', $vital), ['cc' => 'Changed'])->assertRedirect(route('login'));

    expect($vital->fresh()->cc)->toBe('Note');
});
