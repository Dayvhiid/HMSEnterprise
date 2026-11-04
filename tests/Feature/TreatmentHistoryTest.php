<?php

use App\Models\Treat;
use App\Models\User;
use App\Models\Vital;

beforeEach(function () {
    $this->user = User::factory()->create();
});

function treatmentHistoryPage($test, string $patientId)
{
    // VitalsController::search() reads the raw $_GET superglobal, which the test client does not populate.
    $_GET['query'] = $patientId;

    return $test->actingAs($test->user)->get(route('search.get', ['query' => $patientId]));
}

test('treatment history shows the remark and does not hide any columns', function () {
    Treat::create(['patient_id' => '900/01/2026', 'duration' => '1 week', 'remark' => 'Review in two weeks', 'rtc' => '2 weeks']);

    treatmentHistoryPage($this, '900/01/2026')
        ->assertOk()
        ->assertSee('Remark')
        ->assertSee('Review in two weeks')
        ->assertSee('2 weeks')
        ->assertDontSee('display: none', false);
});

test('examinations taken shows a check for each section filled in at that visit', function () {
    // Saved the same way the vitals form saves: one vitals row and one vital2 row per visit.
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '901/01/2026',
        'ODunaided' => '6/9',
        'ODSPH' => '-1.00',
        'arodsph' => '-1.25',
        'odnct' => '14mmHg',
        'fossph' => '-0.75', // left-eye final RX lives in vital2s
    ])->assertRedirect();

    $response = treatmentHistoryPage($this, '901/01/2026')->assertOk()->assertSee('Examinations Taken');

    $taken = ['Visual Acuity', 'Lensometry', 'Auto-Refraction', 'IOP', 'Final RX'];
    $notTaken = ['Retinoscope', 'Subjective Refraction', 'External Examination', 'Internal Examination'];

    foreach ($taken as $section) {
        $response->assertSeeInOrder([$section, '(taken)'], false);
    }
    foreach ($notTaken as $section) {
        $response->assertSeeInOrder([$section, '(not taken)'], false);
    }
    expect(substr_count($response->getContent(), '(taken)'))->toBe(count($taken))
        ->and(substr_count($response->getContent(), '(not taken)'))->toBe(count($notTaken));
});

test('each vitals visit is listed separately, newest first', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '902/01/2026', 'ODunaided' => '6/12']);
    $this->travel(1)->days();
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '902/01/2026', 'odnct' => '18mmHg']);

    $first = Vital::where('patient_code', '902/01/2026')->orderBy('id')->first();
    $second = Vital::where('patient_code', '902/01/2026')->orderBy('id')->skip(1)->first();

    $response = treatmentHistoryPage($this, '902/01/2026')->assertOk();
    $response->assertSeeInOrder([
        $second->created_at->format('F j, Y g:i A'),
        $first->created_at->format('F j, Y g:i A'),
    ]);
    expect(substr_count($response->getContent(), '(taken)'))->toBe(2);
});

test('a patient with no vitals sees that no examinations are recorded', function () {
    Treat::create(['patient_id' => '903/01/2026', 'duration' => '1 week', 'remark' => 'Only a treatment plan']);

    treatmentHistoryPage($this, '903/01/2026')
        ->assertOk()
        ->assertSee('No examinations recorded for this patient.');
});
