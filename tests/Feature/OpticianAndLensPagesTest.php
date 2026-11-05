<?php

use App\Models\Lens;
use App\Models\Opticians;
use App\Models\PatientInfo;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'optician']);
});

function dispensed(array $attributes): Opticians
{
    return Opticians::create($attributes + ['date' => '2026-11-01', 'power' => '-1.00', 'frame_type' => 'Metal', 'qty' => 1]);
}

test('the five optician and lens pages use the clinical layout without old branding or CDN assets', function (string $route) {
    $this->actingAs($this->user)->get(route($route))
        ->assertOk()
        ->assertSee('data-zone="workspace"', false)
        ->assertDontSee('HealthPlus')
        ->assertDontSee('>About<', false)
        ->assertDontSee('googleusercontent.com', false)
        ->assertDontSee('cdn.tailwindcss.com', false)
        ->assertDontSee('cdn.jsdelivr.net', false);
})->with(['optician.records', 'optician.list', 'optician.find', 'admin2.lens', 'lens.list']);

test('the dispensing entry form keeps its field names, adds rows without submitting, and starts on today', function () {
    $this->actingAs($this->user)->get(route('optician.records'))
        ->assertSee('name="patients[0][date]" value="'.now()->toDateString().'"', false)
        ->assertSee('name="patients[0][patient_name]"', false)
        ->assertSee('name="patients[__N__][qty]"', false)
        ->assertSee('<button type="button" data-add-row', false)
        ->assertSee('action="'.route('optician.store').'"', false)
        ->assertSee('name="patients[0][patient_id]"', false)
        ->assertSee('Patient ID')
        ->assertDontSee('Posted from')
        ->assertDontSee('Card number')
        ->assertDontSee('[posted_from]', false)
        ->assertDontSee('[card_number]', false);
});

function registeredPatient(string $pid, string $first = 'Ada', string $last = 'Obi'): PatientInfo
{
    $patient = new PatientInfo();
    $patient->forceFill(['patient_id' => $pid, 'first_name' => $first, 'last_name' => $last, 'gender' => 'female'])->save();

    return $patient;
}

test('dispensing rows are saved with the patient ID and a failed save keeps every row typed', function () {
    registeredPatient('77/11/2026');
    registeredPatient('78/11/2026');

    $this->actingAs($this->user)->from(route('optician.records'))->post(route('optician.store'), ['patients' => [
        ['date' => '2026-11-02', 'patient_id' => '77/11/2026', 'patient_name' => 'Ada Obi', 'power' => '-1.25', 'frame_type' => 'Metal', 'qty' => 1],
    ]])->assertRedirect(route('optician.records'));
    $saved = Opticians::where('card_number', '77/11/2026')->sole();
    expect($saved->patient_name)->toBe('Ada Obi')->and($saved->posted_from)->toBeNull();

    $this->actingAs($this->user)->from(route('optician.records'))->post(route('optician.store'), ['patients' => [
        0 => ['date' => '2026-11-02', 'patient_id' => '78/11/2026', 'patient_name' => 'Kept Row', 'power' => '', 'frame_type' => '', 'qty' => ''],
        3 => ['date' => '2026-11-02', 'patient_id' => '78/11/2026', 'patient_name' => '', 'power' => '', 'frame_type' => '', 'qty' => ''],
    ]])->assertRedirect(route('optician.records'));

    $this->get(route('optician.records'))
        ->assertSee('value="Kept Row"', false)
        ->assertSee('name="patients[3][patient_id]" value="78/11/2026"', false)
        ->assertSee('data-next-index="4"', false)
        ->assertSee('Please fix the following');
    expect(Opticians::count())->toBe(1);
});

test('a dispensing row with an unknown patient ID is rejected', function () {
    $this->actingAs($this->user)->from(route('optician.records'))->post(route('optician.store'), ['patients' => [
        ['date' => '2026-11-02', 'patient_id' => '999/99/9999', 'patient_name' => 'Nobody'],
    ]])->assertRedirect(route('optician.records'))->assertSessionHasErrors('patients.0.patient_id');

    $this->get(route('optician.records'))->assertSee('No registered patient has the ID &quot;999/99/9999&quot;.', false);
    expect(Opticians::count())->toBe(0);
});

test('a dispensing row without a patient ID is still accepted', function () {
    $this->actingAs($this->user)->post(route('optician.store'), ['patients' => [
        ['date' => '2026-11-02', 'patient_name' => 'Walk-in'],
    ]])->assertSessionHasNoErrors();

    expect(Opticians::sole()->card_number)->toBeNull();
});

test('the dispensing list shows the patient ID linked to the chart and no Posted from column', function () {
    $patient = registeredPatient('55/11/2026');
    dispensed(['patient_name' => 'Ada Obi', 'card_number' => '55/11/2026']);
    dispensed(['patient_name' => 'Paper Card', 'card_number' => 'OLD-12']);

    $this->actingAs($this->user)->get(route('optician.list'))
        ->assertSee('<a href="'.route('patient.show', $patient->id).'" class="font-medium text-sky-700 hover:underline">55/11/2026</a>', false)
        ->assertSee('OLD-12')
        ->assertDontSee('Posted from')
        ->assertDontSee('Card number');
});

test('the patient lookup lists an exact patient ID first', function () {
    foreach (range(10, 19) as $n) {
        registeredPatient("{$n}1/11/2026", 'Other', (string) $n);
    }
    $exact = registeredPatient('1/11/2026', 'Exact', 'Match');
    PatientInfo::where('id', '!=', $exact->id)->update(['updated_at' => now()->addMinute()]);

    $this->actingAs($this->user)->getJson(route('search.global', ['q' => '1/11/2026']))
        ->assertOk()
        ->assertJsonPath('patients.0.patient_id', '1/11/2026');
});

test('the dispensing list is paged, newest first, and old find/search URLs show it', function () {
    dispensed(['date' => '2026-10-01', 'patient_name' => 'Older Patient', 'card_number' => 'A-1']);
    dispensed(['date' => '2026-11-03', 'patient_name' => 'Newer Patient', 'card_number' => 'A-2']);

    $this->actingAs($this->user)->get(route('optician.list'))
        ->assertSeeInOrder(['Newer Patient', 'Older Patient'])
        ->assertSee('03-Nov-2026')
        ->assertSee('of <strong>2</strong> records', false);

    $this->actingAs($this->user)->get(route('optician.search', ['query' => 'A-1']))
        ->assertSee('Older Patient')->assertDontSee('Newer Patient');
    $this->actingAs($this->user)->get(route('optician.search', ['query' => 'newer']))
        ->assertSee('Newer Patient')->assertDontSee('Older Patient');
    $this->actingAs($this->user)->get(route('optician.find'))
        ->assertSee('name="query"', false)->assertSee('Newer Patient');
});

test('saving lenses opens the lens list with a confirmation', function () {
    $this->actingAs($this->user)->post(route('lens.store'), ['inputs' => [
        ['sn' => '1', 'name' => 'CR39 Single Vision', 'price' => '4500', 'special_code' => 'L-01', 'quantity' => '12'],
    ]])->assertRedirect(route('lens.list'));

    $this->get(route('lens.list'))
        ->assertSee('Lens list updated.')
        ->assertSee('CR39 Single Vision')
        ->assertSee('4,500.00');
});

test('the lens entry form keeps its field names and numbers new rows', function () {
    $this->actingAs($this->user)->get(route('admin2.lens'))
        ->assertSee('name="inputs[0][sn]" value="1"', false)
        ->assertSee('name="inputs[__N__][sn]"', false)
        ->assertSee('value="__ROW__"', false)
        ->assertSee('name="inputs[0][special_code]"', false);
});

test('the lens list searches, flags out-of-stock lenses and confirms deletes', function () {
    Lens::create(['name' => 'Photochromic Grey', 'price' => '9000', 'special_code' => 'PG-1', 'quantity' => '0']);
    Lens::create(['name' => 'Blue Cut', 'price' => '7000', 'special_code' => 'BC-2', 'quantity' => '5']);

    $this->actingAs($this->user)->get(route('lens.list'))
        ->assertSeeInOrder(['Blue Cut', 'Photochromic Grey', 'Out of stock'])
        ->assertSee('return confirm(', false);

    $this->actingAs($this->user)->get(route('lens.list', ['query' => 'pg-1']))
        ->assertSee('Photochromic Grey')->assertDontSee('Blue Cut');
});

test('deleting a lens returns to the list with a message', function () {
    $lens = Lens::create(['name' => 'Old Stock', 'price' => '100', 'quantity' => '1']);

    $this->actingAs($this->user)->delete(route('lens.delete', ['len' => $lens->id]))
        ->assertRedirect(route('lens.list'));
    $this->get(route('lens.list'))->assertSee('Lens &quot;Old Stock&quot; deleted.', false);
    expect(Lens::find($lens->id))->toBeNull();
});
