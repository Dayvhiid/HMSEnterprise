<?php

use App\Models\PatientInfo;
use App\Models\Treat;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $patient = new PatientInfo();
    $patient->forceFill(['patient_id' => '420/07/2026', 'first_name' => 'Bisi', 'last_name' => 'Ola', 'gender' => 'female'])->save();
    $this->patient = $patient;
});

test('opening the form from the chart fills in the patient and shows their chart', function () {
    $this->actingAs($this->user)->get(route('doctors.treatment', ['patient' => '420/07/2026']))
        ->assertOk()
        ->assertSee('data-patient-id="420/07/2026"', false)
        ->assertSee('data-zone="action-bar"', false)
        ->assertSee('Bisi Ola')
        ->assertSeeInOrder(['name="patient_id"', 'value="420/07/2026"', 'readonly'], false)
        ->assertDontSee('cdn.tailwindcss.com', false)
        ->assertDontSee('googleusercontent.com', false);
});

test('Cancel is a link, so it can no longer submit the plan', function () {
    $html = $this->actingAs($this->user)->get(route('doctors.treatment', ['patient' => '420/07/2026']))->getContent();

    expect($html)->toContain('href="'.route('search.get', ['query' => '420/07/2026']).'" class="btn-secondary">Cancel</a>')
        ->and(substr_count($html, 'form="treatment-form"'))->toBe(1)
        ->and(preg_match('/<button[^>]*>\s*(<span[^>]*>)?\s*Cancel/', $html))->toBe(0);
});

test('each lens box is labelled with the option it saves', function () {
    $this->actingAs($this->user)->get(route('doctors.treatment'))
        ->assertSeeInOrder(['value="single vision tintable"', 'Single vision tintable</span>'], false)
        ->assertSeeInOrder(['value="single vision transition A/R"', 'Single vision transition A/R</span>'], false)
        ->assertSeeInOrder(['value="bifocal tintable"', 'Bifocal tintable</span>'], false)
        ->assertSeeInOrder(['value="Special Order Fused Bifocal Tintable"', 'Fused bifocal tintable</span>'], false);
});

test('a ticked lens option is saved exactly as labelled', function () {
    $this->actingAs($this->user)->post(route('treatment.store'), [
        'patient_id' => '420/07/2026', 'singlevision' => ['single vision transition A/R'], 'tab' => 'Paracetamol',
    ])->assertRedirect(route('search.get', ['query' => '420/07/2026']));

    $plan = Treat::where('patient_id', '420/07/2026')->sole();
    expect(json_decode($plan->single_vision, true))->toBe(['single vision transition A/R'])
        ->and($plan->tab)->toBe('Paracetamol')
        ->and($plan->duration)->toBe('');
});

test('a failed save keeps what was typed and ticked', function () {
    $this->actingAs($this->user)->from(route('doctors.treatment'))->post(route('treatment.store'), [
        'patient_id' => 'NOPE', 'gutt' => 'Timolol', 'duration' => '2 weeks', 'bifocal' => ['bifocal tintable'], 'remark' => 'Recheck IOP',
    ])->assertRedirect(route('doctors.treatment'));

    $this->get(route('doctors.treatment'))
        ->assertSee('No patient has that Patient ID.')
        ->assertSee('value="Timolol"', false)
        ->assertSee('<option selected>2 weeks</option>', false)
        ->assertSee('Recheck IOP')
        ->assertSeeInOrder(['value="bifocal tintable"', 'checked'], false);
});

test('the last final Rx can be inserted into the prescription', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '420/07/2026', 'fodsph' => '-1.25', 'fossph' => '-1.75', 'form_token' => 'rx-insert']);

    $this->actingAs($this->user)->get(route('doctors.treatment', ['patient' => '420/07/2026']))
        ->assertSee('id="insert-rx"', false)
        ->assertSee('OD: SPH -1.25', false)
        ->assertSee('OS: SPH -1.75', false);
});

test('both long forms have a floating section bar whose links point at real sections', function (string $route, array $sections) {
    $html = $this->actingAs($this->user)->get(route($route, ['patient' => '420/07/2026']))->assertOk()->getContent();

    expect($html)->toContain('data-section-bar');
    foreach ($sections as $id) {
        expect($html)->toContain('href="#'.$id.'"')->toContain('id="'.$id.'"');
    }
})->with([
    'treatment' => ['doctors.treatment', ['patient', 'medication', 'prescription-section', 'lenses', 'remarks']],
    'exam' => ['doctors.vitals', ['patient', 'history', 'va', 'lensometry', 'refraction', 'final-rx', 'iop', 'ocular']],
]);
