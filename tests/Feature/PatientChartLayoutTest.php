<?php

use App\Models\PatientInfo;
use App\Models\Treat;
use App\Models\User;
use App\Models\Vital;
use App\Models\vital2;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->patient = new PatientInfo();
    $this->patient->forceFill([
        'patient_id' => '415/07/2026',
        'first_name' => 'Funke',
        'last_name' => 'Adeyemi',
        'date' => '1984-02-03',
        'gender' => 'female',
        'phone' => '08031112222',
        'email' => 'funke@example.com',
        'city' => 'Ikeja',
        'state' => 'Lagos',
        'street' => '4 Allen Avenue',
        'occupation' => 'Banker',
        'emergency_fullname' => 'Tunde Adeyemi',
        'emergency_relationship' => 'Husband',
        'emergency_phone' => '08000000002',
        'emergency_email' => 'tunde@example.com',
    ])->save();

    $this->card = fn () => $this->actingAs($this->user)->get(route('patient.show', $this->patient->id));
});

test('the patient card uses the clinical layout zones', function () {
    ($this->card)()
        ->assertOk()
        ->assertSee('data-zone="patient-banner"', false)
        ->assertSee('data-zone="chart-nav"', false)
        ->assertSee('data-zone="workspace"', false)
        ->assertSee('data-zone="context"', false)
        ->assertSee('data-zone="action-bar"', false)
        ->assertDontSee('cdn.tailwindcss.com', false)
        ->assertDontSee('googleusercontent.com', false);
});

test('the banner shows the patient\'s real identity details', function () {
    $expectedAge = \Carbon\Carbon::parse('1984-02-03')->age;

    ($this->card)()
        ->assertOk()
        ->assertSee('Funke Adeyemi')
        ->assertSee('Female')
        ->assertSee($expectedAge.'y')
        ->assertSee('DOB 03-Feb-1984')
        ->assertSee('415/07/2026')
        ->assertSee('08031112222');
});

test('the old placeholder date of birth is gone', function () {
    ($this->card)()->assertOk()->assertDontSee('1985-08-15');
});

test('a missing date of birth says so instead of inventing one', function () {
    $this->patient->forceFill(['date' => null, 'age' => '57'])->save();

    ($this->card)()
        ->assertOk()
        ->assertSee('DOB not recorded')
        ->assertSee('57');
});

test('the chart navigation links to this patient\'s sections and new-record forms', function () {
    ($this->card)()
        ->assertOk()
        ->assertSee(route('patient.edit', $this->patient->id), false)
        ->assertSee(route('vitals.get', ['query' => '415/07/2026']), false)
        ->assertSee(route('search.get', ['query' => '415/07/2026']), false)
        ->assertSee(route('doctors.vitals', ['patient' => '415/07/2026']), false)
        ->assertSee(route('doctors.treatment', ['patient' => '415/07/2026']), false);
});

test('the context panel shows the latest examination, final Rx and treatment', function () {
    $old = Vital::create(['patient_code' => '415/07/2026', 'odunaided' => '6/60', 'fodsph' => '-9.00']);
    $old->forceFill(['created_at' => '2026-01-10 09:00:00'])->save();

    $latest = Vital::create([
        'patient_code' => '415/07/2026',
        'cc' => 'Blurred distance vision',
        'odunaided' => '6/18', 'osunaided' => '6/24',
        'odnct' => '18', 'osnct' => '21',
        'fodsph' => '-1.25', 'fodcyl' => '-0.50', 'fodaxis' => '180', 'fodva' => '6/6',
    ]);
    $latest->forceFill(['created_at' => '2026-10-30 11:00:00'])->save();
    $left = vital2::create(['patient_code' => '415/07/2026', 'fossph' => '-1.75', 'foscyl' => '-0.25', 'fosaxis' => '170', 'fosva' => '6/6']);
    $left->forceFill(['created_at' => '2026-10-30 11:00:00'])->save();

    Treat::create(['patient_id' => '415/07/2026', 'duration' => '1 month', 'gutt' => 'Timolol 0.5% bd', 'prescription' => 'Single vision distance']);

    ($this->card)()
        ->assertOk()
        ->assertSee('30-Oct-2026')
        ->assertSee('Blurred distance vision')
        ->assertSeeInOrder(['VA (unaided)', '6/18', '6/24', 'IOP', '18', '21'])
        ->assertSeeInOrder(['Last final Rx', 'OD', '-1.25', '-0.50', '180', 'OS', '-1.75', '-0.25', '170'])
        ->assertDontSee('-9.00')
        ->assertSee('Timolol 0.5% bd')
        ->assertSee('Single vision distance');
});

test('the context panel says when nothing is recorded yet', function () {
    ($this->card)()
        ->assertOk()
        ->assertSee('No examinations recorded.')
        ->assertSee('No final Rx recorded.')
        ->assertSee('No treatment plans recorded.');
});

test('patient details are escaped in the banner', function () {
    $this->patient->forceFill(['first_name' => '<img src=x onerror=alert(1)>'])->save();

    ($this->card)()
        ->assertOk()
        ->assertDontSee('<img src=x onerror=alert(1)>', false);
});

test('examinations, treatment and personal details all open inside the patient chart', function (string $page, string $active) {
    $url = match ($page) {
        'vitals' => route('vitals.get', ['query' => '415/07/2026']),
        'treatment' => route('search.get', ['query' => '415/07/2026']),
        'details' => route('patient.edit', $this->patient->id),
    };

    $this->actingAs($this->user)->get($url)
        ->assertOk()
        ->assertSee('data-zone="patient-banner"', false)
        ->assertSee('data-zone="chart-nav"', false)
        ->assertSee('data-zone="context"', false)
        ->assertSee('data-zone="action-bar"', false)
        ->assertSee('Funke Adeyemi')
        ->assertSee('aria-current="page"', false)
        ->assertDontSee('cdn.tailwindcss.com', false)
        ->assertDontSee('googleusercontent.com', false);
})->with([
    ['vitals', 'vitals'],
    ['treatment', 'treatment'],
    ['details', 'details'],
]);

test('chart pages for an unknown patient ID say so instead of showing a banner', function (string $route) {
    $this->actingAs($this->user)->get(route($route, ['query' => '999/99/9999']))
        ->assertOk()
        ->assertSee('No registered patient has the ID 999/99/9999')
        ->assertDontSee('data-zone="patient-banner"', false);
})->with(['vitals.get', 'search.get']);

test('the exam history labels each case-history box with the same heading as the entry form', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '415/07/2026', 'pohx' => 'POHX-TEXT', 'lee' => 'LEE-TEXT', 'pmhx' => 'PMHX-TEXT', 'pfohx' => 'PFOHX-TEXT',
    ]);

    $this->actingAs($this->user)->get(route('vitals.get', ['query' => '415/07/2026']))
        ->assertSeeInOrder([
            'Past ocular history', 'POHX-TEXT',
            'Last eye exam', 'LEE-TEXT',
            'Past medical history', 'PMHX-TEXT',
            'Past family ocular history', 'PFOHX-TEXT',
        ]);
});

test('only the newest visit is expanded on the exam history', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '415/07/2026', 'cc' => 'Older', 'form_token' => 'a']);
    $this->travel(1)->days();
    $this->actingAs($this->user)->post(route('vitals.store'), ['patient_code' => '415/07/2026', 'cc' => 'Newer', 'form_token' => 'b']);

    $html = $this->actingAs($this->user)->get(route('vitals.get', ['query' => '415/07/2026']))->getContent();

    expect(substr_count($html, '<details class="vitals-visit'))->toBe(2)
        ->and(preg_match_all('/<details class="vitals-visit[^>]*\bopen\b/', $html))->toBe(1);
});

test('treatment plans are listed newest first', function () {
    Treat::create(['patient_id' => '415/07/2026', 'duration' => '1 week', 'remark' => 'OLDER-PLAN']);
    $this->travel(1)->days();
    Treat::create(['patient_id' => '415/07/2026', 'duration' => '1 week', 'remark' => 'NEWER-PLAN']);

    $this->actingAs($this->user)->get(route('search.get', ['query' => '415/07/2026']))
        ->assertSeeInOrder(['NEWER-PLAN', 'OLDER-PLAN']);
});

test('saving personal details keeps the full name and the recorded sex', function () {
    $this->patient->forceFill(['fullname' => 'Funke Adeyemi'])->save();

    $form = $this->actingAs($this->user)->get(route('patient.edit', $this->patient->id))
        ->assertOk()
        ->assertSee('name="fullname" value="Funke Adeyemi"', false)
        ->assertSee('<option value="Female" selected', false);

    $this->actingAs($this->user)->put(route('patient.update', $this->patient->id), [
        'first_name' => 'Funke', 'last_name' => 'Adeyemi', 'fullname' => 'Funke Adeyemi', 'gender' => 'Female', 'phone' => '08031112222',
    ])->assertRedirect(route('patient.show', $this->patient->id));

    expect($this->patient->fresh()->fullname)->toBe('Funke Adeyemi')
        ->and($this->patient->fresh()->gender)->toBe('Female');
});

test('recording an exam from the chart fills in the patient and shows their chart', function () {
    $this->actingAs($this->user)->get(route('doctors.vitals', ['patient' => '415/07/2026']))
        ->assertOk()
        ->assertSee('data-zone="patient-banner"', false)
        ->assertSee('data-zone="action-bar"', false)
        ->assertSee('Funke Adeyemi')
        ->assertSee('data-patient-id="415/07/2026"', false)
        ->assertSeeInOrder(['name="patient_code"', 'readonly', 'value="415/07/2026"'], false)
        ->assertSee('id="copy-subjective"', false)
        ->assertDontSee('cdn.tailwindcss.com', false)
        ->assertDontSee('googleusercontent.com', false);
});

test('a new exam without a known patient keeps the Patient ID box editable', function () {
    $this->actingAs($this->user)->get(route('doctors.vitals', ['patient' => '999/99/9999']))
        ->assertOk()
        ->assertSee('name="patient_code"  value="999/99/9999"', false)
        ->assertDontSee('data-patient-id=', false);
});

test('the edit form opens inside the patient chart with every saved value', function () {
    $this->actingAs($this->user)->post(route('vitals.store'), [
        'patient_code' => '415/07/2026', 'cc' => 'Glare at night', 'fodsph' => '-1.25', 'fossph' => '-1.75', 'odnct' => '17', 'form_token' => 'edit-chart',
    ]);
    $vital = Vital::where('patient_code', '415/07/2026')->sole();

    $this->actingAs($this->user)->get(route('vitals.edit', $vital))
        ->assertOk()
        ->assertSee('data-zone="patient-banner"', false)
        ->assertSee('Glare at night')
        ->assertSee('name="fodsph" value="-1.25"', false)
        ->assertSee('name="fossph" value="-1.75"', false)
        ->assertSee('name="odnct" value="17"', false)
        ->assertSee(route('vitals.update', $vital), false);
});
