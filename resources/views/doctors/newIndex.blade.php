{{-- New treatment plan & lens prescription. Clinical layout (ADR-005). Posts to TreatmentController@store;
     field names and stored lens values are unchanged. $chart is the patient when known (?patient= or a failed save). --}}
@php
    $patientCode = old('patient_id', $patientCode ?? '');
    $durations = ['1 Day', '2 Day', '3 Day', '4 Day', '5 Day', '6 Day', '1 week', '2 weeks', '3 weeks', '1 Month'];
    $medication = [
        // name => [label, hint]
        'tab' => ['TAB', 'Tablets'],
        'gutt' => ['GUTT', 'Eye drops'],
        'oc' => ['OC', 'Ointment'],
        'dosage' => ['Dosage', 'e.g. 1 drop 3 times daily'],
        'sur' => ['SUR', null],
        'rtc' => ['RTC', 'Return to clinic, e.g. 2 weeks'],
    ];
    // Stored value => label shown. Before 2026-11-05 the labels were shifted by one in the first three groups,
    // so the box ticked saved a different option. Each box is now labelled with the option it actually saves.
    // The three "A/R B/C" options marked new were shown on the old form but could never be saved.
    $lensGroups = [
        'singlevision' => ['Single vision', [
            'single vision tintable' => 'Single vision tintable',
            'single vision tintable photochromic' => 'Single vision tintable photochromic',
            'single vision transition A/R' => 'Single vision transition A/R',
            'single vision transition A/R B/C' => 'Single vision transition A/R B/C',
        ]],
        'bifocal' => ['Bifocal', [
            'bifocal tintable' => 'Bifocal tintable',
            'bifocal transition A/R' => 'Bifocal transition A/R',
            'bifocal transition A/R B/C' => 'Bifocal transition A/R B/C',
        ]],
        'progressive' => ['Progressive', [
            'Progressive Tintable' => 'Progressive tintable',
            'Progressive Tintable A/R' => 'Progressive tintable A/R',
            'Progressive Tintable A/R B/C' => 'Progressive tintable A/R B/C',
        ]],
        'specialorder' => ['Special order', [
            'Single Order Single vision tintable' => 'Single vision tintable',
            'Special Order Fused Bifocal Tintable' => 'Fused bifocal tintable',
            'Special Order DTOP Bifocal Tintable' => 'DTOP bifocal tintable',
            'Special Order Fused Bifocal A/R' => 'Fused bifocal A/R',
            'Special Order DTOP A/R' => 'DTOP A/R',
            'Special Order Fused Bifocal A/R B/C' => 'Fused bifocal A/R B/C',
            'Special Order DTOP Bifocal A/R B/C' => 'DTOP bifocal A/R B/C',
        ]],
    ];
    // Last Final Rx as one line per eye, for the "Insert last Final Rx" button.
    $lastRx = $chart?->latestVisit()['rx'] ?? null;
    $lastRxText = $lastRx ? collect($lastRx)->map(function ($row, $eye) {
        if (! $row) {
            return null;
        }
        $parts = array_filter([
            filled($row['sph']) ? 'SPH '.$row['sph'] : null,
            filled($row['cyl']) ? 'CYL '.$row['cyl'] : null,
            filled($row['axis']) ? 'AXIS '.$row['axis'] : null,
            filled($row['add']) ? 'ADD '.$row['add'] : null,
            filled($row['va']) ? 'VA '.$row['va'] : null,
        ]);

        return $eye.': '.implode('  ', $parts);
    })->filter()->implode("\n") : '';
    $exitUrl = filled($patientCode) ? route('search.get', ['query' => $patientCode]) : route('doctors.index');
@endphp
<x-layouts.clinical :title="'New treatment plan'.($chart ? ' - '.$chart->name() : '')">
    @if ($chart)
        <x-slot:banner><x-clinical.patient-banner :chart="$chart" /></x-slot:banner>
        <x-slot:nav><x-clinical.chart-nav :chart="$chart" active="treatment" /></x-slot:nav>
        <x-slot:context><x-clinical.patient-context :chart="$chart" /></x-slot:context>
    @endif

    <div>
        <h1 class="text-xl font-semibold text-slate-900">Treatment plan &amp; lens prescription</h1>
        <p class="text-sm text-slate-600">Fill in what applies to this visit; everything except the Patient ID is optional.</p>
    </div>

    @if ($errors->any())
        <p class="text-sm font-medium text-red-800">The plan was not saved. Everything you typed is still here.</p>
    @endif

    <x-clinical.section-bar :sections="[
        'patient' => 'Patient',
        'medication' => 'Medication',
        'prescription-section' => 'Spectacle prescription',
        'lenses' => 'Lens type',
        'remarks' => 'Remarks',
    ]" />

    <form id="treatment-form" method="POST" action="{{ route('treatment.store') }}" class="space-y-4">
        @csrf

        <x-clinical.panel title="Patient" id="patient">
            <div class="max-w-xs">
                <label for="patient_id" class="field-label">Patient ID</label>
                <input id="patient_id" name="patient_id" required value="{{ $patientCode }}" placeholder="Enter Patient ID" @if ($chart) readonly @endif
                       @class(['field-input font-mono', 'bg-slate-50 text-slate-600' => $chart, 'border-red-400' => $errors->has('patient_id')])>
                @error('patient_id')<p class="pt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                @if ($chart)
                    <p class="pt-1 text-xs text-slate-500">Planning for {{ $chart->name() }}. <a href="{{ route('doctors.treatment') }}" class="font-medium text-sky-700 hover:underline">Different patient?</a></p>
                @else
                    <p class="pt-1 text-xs text-slate-500">Tip: open the patient from search first and the ID fills in for you.</p>
                @endif
            </div>
        </x-clinical.panel>

        <x-clinical.panel title="Medication" id="medication">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($medication as $name => [$label, $hint])
                    <div>
                        <label for="{{ $name }}" class="field-label">{{ $label }} @if ($hint && $name !== 'dosage' && $name !== 'rtc')<span class="font-normal text-slate-500">({{ $hint }})</span>@endif</label>
                        <input id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" class="field-input"
                               @if ($name === 'dosage' || $name === 'rtc') placeholder="{{ $hint }}" @endif>
                    </div>
                @endforeach
                <div>
                    <label for="duration" class="field-label">Duration</label>
                    <select id="duration" name="duration" class="field-input">
                        <option value="">Not set</option>
                        @foreach ($durations as $duration)
                            <option @selected(old('duration') === $duration)>{{ $duration }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-clinical.panel>

        <x-clinical.panel title="Spectacle prescription" id="prescription-section">
            @if ($lastRxText !== '')
                <x-slot:headerActions>
                    <button type="button" id="insert-rx" data-rx="{{ $lastRxText }}" class="text-sm font-medium text-sky-700 hover:underline">Insert last Final Rx</button>
                </x-slot:headerActions>
            @endif
            <label for="prescription" class="sr-only">Prescription</label>
            <textarea id="prescription" name="prescription" rows="4" placeholder="Enter prescription details" class="field-input font-mono">{{ old('prescription') }}</textarea>
        </x-clinical.panel>

        <x-clinical.panel title="Lens type" id="lenses">
            <div class="grid gap-6 md:grid-cols-2 2xl:grid-cols-4">
                @foreach ($lensGroups as $name => [$groupLabel, $options])
                    <fieldset>
                        <legend class="mb-2 text-sm font-semibold text-slate-800">{{ $groupLabel }}</legend>
                        <div class="space-y-1">
                            @foreach ($options as $value => $label)
                                <label class="flex cursor-pointer items-start gap-2.5 rounded-md px-2 py-1.5 text-sm text-slate-700 hover:bg-slate-50">
                                    <input type="checkbox" name="{{ $name }}[]" value="{{ $value }}" @checked(in_array($value, (array) old($name, []), true))
                                           class="mt-0.5 h-4 w-4 rounded border-slate-300 text-sky-700 focus:ring-sky-600">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                @endforeach
            </div>
        </x-clinical.panel>

        <x-clinical.panel title="Remarks" id="remarks">
            <label for="remark" class="sr-only">Remarks</label>
            <textarea id="remark" name="remark" rows="3" placeholder="Enter any remarks" class="field-input">{{ old('remark') }}</textarea>
        </x-clinical.panel>
    </form>

    <x-slot:actions>
        <span id="treatment-dirty" class="mr-auto hidden text-sm text-amber-700">Unsaved changes</span>
        <a href="{{ $exitUrl }}" class="btn-secondary">Cancel</a>
        <button type="submit" form="treatment-form" id="treatment-save" class="btn-primary"><span>Save treatment plan</span></button>
    </x-slot:actions>

    <x-slot:scripts>
        <script>
            (function () {
                var form = document.getElementById('treatment-form');
                var saveButton = document.getElementById('treatment-save');
                var dirty = false;
                function markDirty() { dirty = true; document.getElementById('treatment-dirty').classList.remove('hidden'); }

                // Enter in a single-line field moves to the next field instead of saving a half-finished plan.
                form.addEventListener('keydown', function (event) {
                    if (event.key !== 'Enter' || event.target.tagName !== 'INPUT') return;
                    event.preventDefault();
                    var fields = Array.prototype.filter.call(form.elements, function (el) {
                        return /^(INPUT|TEXTAREA|SELECT)$/.test(el.tagName) && el.type !== 'hidden' && !el.disabled && !el.readOnly;
                    });
                    var next = fields[fields.indexOf(event.target) + 1];
                    if (next) next.focus();
                });
                form.addEventListener('input', markDirty);
                form.addEventListener('change', markDirty);

                var insert = document.getElementById('insert-rx');
                if (insert) {
                    insert.addEventListener('click', function () {
                        var box = document.getElementById('prescription');
                        box.value = box.value ? box.value.replace(/\s+$/, '') + '\n' + insert.dataset.rx : insert.dataset.rx;
                        box.focus();
                        markDirty();
                    });
                }

                // One click saves once.
                form.addEventListener('submit', function () {
                    dirty = false;
                    saveButton.disabled = true;
                    saveButton.querySelector('span').textContent = 'Saving…';
                });
                window.addEventListener('beforeunload', function (event) {
                    if (dirty) { event.preventDefault(); event.returnValue = ''; }
                });
                window.addEventListener('pageshow', function (event) {
                    if (event.persisted) { saveButton.disabled = false; saveButton.querySelector('span').textContent = 'Save treatment plan'; }
                });
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
