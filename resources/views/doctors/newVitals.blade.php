{{-- Record (or edit) a comprehensive eye examination. Clinical layout (ADR-005).
     New exam: DoctorsController::vitals; edit: VitalsController::edit ($vital + $prefill).
     $chart is the patient when known (from ?patient=, the saved visit, or what was typed before a failed save). --}}
@php
    $editing = isset($vital);
    $prefill = $prefill ?? [];
    $v = fn (string $name) => old($name, $prefill[$name] ?? '');
    $patientCode = $editing ? $vital->patient_code : old('patient_code', $patientCode ?? '');
    $eyes = ['Right eye (OD)', 'Left eye (OS)'];
    $grid = fn (array $rows) => collect($rows)->map(fn ($names) => collect($names)->mapWithKeys(fn ($n) => [$n => $v($n)])->all())->all();
    $sections = [
        'patient' => 'Patient',
        'history' => 'Case history',
        'va' => 'Visual acuity',
        'lensometry' => 'Lensometry',
        'refraction' => 'Refraction',
        'final-rx' => 'Final Rx',
        'iop' => 'IOP',
        'ocular' => 'Ocular health',
    ];
    $historyFields = [
        'cc' => 'Chief complaint',
        'pohx' => 'Past ocular history',
        'lee' => 'Last eye exam',
        'pmhx' => 'Past medical history',
        'pfohx' => 'Past family ocular history',
    ];
    // Cancel goes back to the patient's exam history, or to the clinical home when no patient is chosen yet.
    $exitUrl = filled($patientCode) ? route('vitals.get', ['query' => $patientCode]) : route('doctors.index');
@endphp
<x-layouts.clinical :title="($editing ? 'Edit examination' : 'New examination').($chart ? ' - '.$chart->name() : '')">
    @if ($chart)
        <x-slot:banner><x-clinical.patient-banner :chart="$chart" /></x-slot:banner>
        <x-slot:nav><x-clinical.chart-nav :chart="$chart" active="vitals" /></x-slot:nav>
        <x-slot:context><x-clinical.patient-context :chart="$chart" /></x-slot:context>
    @endif

    <div>
        <h1 class="text-xl font-semibold text-slate-900">{{ $editing ? 'Edit examination' : 'Comprehensive eye examination' }}</h1>
        @if ($editing)
            <p class="mt-1 rounded-md border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-900">
                Editing the visit of <strong>{{ $vital->created_at->format('F j, Y g:i A') }}</strong> for patient
                <strong>{{ $vital->patient_code }}</strong>. Saving updates this visit; it does not create a new one.
            </p>
        @else
            <p class="text-sm text-slate-600">Fill in the sections you examined; empty sections are fine. Enter moves to the next box.</p>
        @endif
    </div>

    @if ($errors->any())
        <p class="text-sm font-medium text-red-800">The exam was not saved. Everything you typed is still here.</p>
    @endif

    <x-clinical.section-bar :sections="$sections" />

    <form method="post" action="{{ $editing ? route('vitals.update', $vital) : route('vitals.store') }}" id="vitals-form" class="space-y-4">
        @csrf
        @method($editing ? 'PUT' : 'POST')
        @unless ($editing)
            {{-- One-time token: lets the server ignore a second submit of this same form. --}}
            <input type="hidden" name="form_token" value="{{ old('form_token', (string) \Illuminate\Support\Str::uuid()) }}" />
        @endunless

        <x-clinical.panel title="Patient" id="patient">
            <div class="max-w-xs">
                <label for="patient_code" class="field-label">Patient ID</label>
                <input id="patient_code" placeholder="Enter Patient ID" name="patient_code" @if ($editing || $chart) readonly @endif value="{{ $patientCode }}"
                       @class(['field-input font-mono', 'bg-slate-50 text-slate-600' => $editing || $chart, 'border-red-400' => $errors->has('patient_code')])>
                @error('patient_code')<p class="pt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                @if ($chart && ! $editing)
                    <p class="pt-1 text-xs text-slate-500">Recording for {{ $chart->name() }}. <a href="{{ route('doctors.vitals') }}" class="font-medium text-sky-700 hover:underline">Different patient?</a></p>
                @elseif (! $editing)
                    <p class="pt-1 text-xs text-slate-500">Tip: open the patient from search first and the ID fills in for you.</p>
                @endif
            </div>
        </x-clinical.panel>

        <x-clinical.panel title="Case history" id="history">
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($historyFields as $name => $label)
                    <div @class(['md:col-span-2' => $name === 'cc'])>
                        <label for="{{ $name }}" class="field-label">{{ $label }}</label>
                        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $name === 'cc' ? 3 : 2 }}" placeholder="{{ $label }}" class="field-input">{{ $v($name) }}</textarea>
                    </div>
                @endforeach
            </div>
        </x-clinical.panel>

        <div class="grid gap-4 2xl:grid-cols-2">
            <x-clinical.panel title="Visual acuity" id="va">
                <x-clinical.exam-grid title="Distance and near" :columns="['Unaided', 'Pin hole', 'Near VA']" :rows="$grid([
                    $eyes[0] => ['ODunaided', 'ODpinhole', 'ODnearVA'],
                    $eyes[1] => ['OSunaided', 'OSpinhole', 'OSnearVA'],
                ])" />
            </x-clinical.panel>

            <x-clinical.panel title="Lensometry" id="lensometry">
                <x-clinical.exam-grid title="Current spectacles" :columns="['Sph', 'Cyl', 'Axis', 'VA']" :rows="$grid([
                    $eyes[0] => ['ODSPH', 'ODCYL', 'ODAXIS', 'ODVA'],
                    $eyes[1] => ['OSSPH', 'OSCYL', 'OSAXIS', 'OSVA'],
                    'ADD' => ['ADDSPH', 'ADDCYL', 'ADDAXIS', 'ADDVA'],
                ])" />
            </x-clinical.panel>
        </div>

        <x-clinical.panel title="Refraction" id="refraction">
            <div class="space-y-6">
                <div class="grid gap-6 xl:grid-cols-2">
                    <x-clinical.exam-grid title="Auto-refraction" :columns="['Sph', 'Cyl', 'Axis']" :rows="$grid([
                        $eyes[0] => ['arodsph', 'arodcyl', 'arodaxis'],
                        $eyes[1] => ['arosph', 'aroscyl', 'arosaxis'],
                    ])">
                        <div class="mt-3">
                            <label for="arpd" class="field-label">P.D. (Pupillary Distance, mm)</label>
                            <input id="arpd" name="arpd" value="{{ $v('arpd') }}" type="number" step="any" min="40" max="85" placeholder="e.g. 62"
                                   @class(['field-input w-32', 'border-red-400' => $errors->has('arpd')])>
                            @error('arpd')<p class="pt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                        </div>
                    </x-clinical.exam-grid>

                    <x-clinical.exam-grid title="Retinoscopy" :columns="['Sph', 'Cyl', 'Axis']" :rows="$grid([
                        $eyes[0] => ['rodsph', 'rodcyl', 'rodaxis'],
                        $eyes[1] => ['rossph', 'roscyl', 'rosaxis'],
                    ])" />
                </div>

                <x-clinical.exam-grid title="Subjective refraction" :columns="['Sph', 'Cyl', 'Axis', 'VA', 'Add', 'Near VA']" :rows="$grid([
                    $eyes[0] => ['srodsph', 'srodcyl', 'srodaxis', 'srodva', 'srodadd', 'srodnva'],
                    $eyes[1] => ['srosph', 'sroscyl', 'srosaxis', 'srosva', 'srosadd', 'srosnva'],
                ])" />
            </div>
        </x-clinical.panel>

        <x-clinical.panel title="Final Rx" id="final-rx" class="border-sky-200 ring-1 ring-sky-100">
            <x-clinical.exam-grid title="Prescription to dispense" :columns="['Sph', 'Cyl', 'Axis', 'VA', 'Add', 'Near VA']" :rows="$grid([
                $eyes[0] => ['fodsph', 'fodcyl', 'fodaxis', 'fodva', 'fodadd', 'fodnva'],
                $eyes[1] => ['fossph', 'foscyl', 'fosaxis', 'fosva', 'fosadd', 'fosnva'],
            ])" />
            <button type="button" id="copy-subjective" class="mt-3 text-sm font-medium text-sky-700 hover:underline">Copy from subjective refraction</button>
        </x-clinical.panel>

        <div class="grid gap-4 2xl:grid-cols-[minmax(0,2fr)_minmax(0,3fr)]">
            <x-clinical.panel title="IOP" id="iop">
                <x-clinical.exam-grid title="Intra-ocular pressure" :columns="['NCT', 'CCT']" :rows="$grid([
                    $eyes[0] => ['odnct', 'odccct'],
                    $eyes[1] => ['osnct', 'oscct'],
                ])">
                    <div class="mt-3">
                        <label for="iop_taken_at" class="field-label">Date &amp; time IOP was taken</label>
                        <div class="flex items-center gap-2">
                            <input id="iop_taken_at" name="iop_taken_at" type="datetime-local" value="{{ $v('iop_taken_at') }}"
                                   @class(['field-input w-auto', 'border-red-400' => $errors->has('iop_taken_at')])>
                            <button type="button" id="iop-now" class="btn-secondary py-1.5">Now</button>
                        </div>
                        @error('iop_taken_at')<p class="pt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                    </div>
                </x-clinical.exam-grid>
            </x-clinical.panel>

            <x-clinical.panel title="Ocular health" id="ocular">
                <x-clinical.exam-grid title="External and internal examination" :columns="$eyes" :rows="$grid([
                    'Eyelid' => ['eyelidod', 'eyelidos'],
                    'Conjunctiva' => ['conjuctivaod', 'conjuctivaos'],
                    'Cornea' => ['corneaod', 'corneaos'],
                    'Pupil' => ['pupilod', 'pupilos'],
                    'Iris' => ['irisod', 'irisos'],
                    'Lens' => ['lensod', 'lensos'],
                    'Vitreous' => ['vitreousod', 'vitreousos'],
                    'C/D ratio' => ['cdratiood', 'cdratioos'],
                    'Macula' => ['macularod', 'maculaos'],
                ])" />
            </x-clinical.panel>
        </div>
    </form>

    <x-slot:actions>
        <span id="vitals-dirty" class="mr-auto hidden text-sm text-amber-700">Unsaved changes</span>
        <a href="{{ $exitUrl }}" class="btn-secondary">Cancel</a>
        <button type="submit" form="vitals-form" id="vitals-save" data-label="{{ $editing ? 'Save Changes' : 'Save examination' }}" class="btn-primary">
            <span class="truncate">{{ $editing ? 'Save Changes' : 'Save examination' }}</span>
        </button>
    </x-slot:actions>

    <x-slot:scripts>
        <script>
            (function () {
                var form = document.getElementById('vitals-form');
                var saveButton = document.getElementById('vitals-save');
                var dirtyNote = document.getElementById('vitals-dirty');
                var dirty = false;

                // Pressing Enter in a single-line field used to submit (save) the whole exam half-finished.
                // Now Enter moves to the next field instead; only the Save button saves. Enter still adds new lines in text boxes.
                form.addEventListener('keydown', function (event) {
                    if (event.key !== 'Enter' || event.target.tagName !== 'INPUT') {
                        return;
                    }
                    event.preventDefault();
                    var fields = Array.prototype.filter.call(form.elements, function (el) {
                        return (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') && el.type !== 'hidden' && !el.disabled && !el.readOnly;
                    });
                    var next = fields[fields.indexOf(event.target) + 1];
                    if (next) {
                        next.focus();
                    }
                });

                form.addEventListener('input', function () {
                    dirty = true;
                    dirtyNote.classList.remove('hidden');
                });

                // "Now" fills the IOP time from this computer's clock (local time, to the minute).
                document.getElementById('iop-now').addEventListener('click', function () {
                    var now = new Date();
                    var pad = function (n) { return String(n).padStart(2, '0'); };
                    document.getElementById('iop_taken_at').value = now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate())
                        + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
                    form.dispatchEvent(new Event('input'));
                });

                // Final Rx usually starts from the subjective result; copy it, then adjust. Only empty boxes are filled.
                document.getElementById('copy-subjective').addEventListener('click', function () {
                    // Subjective field => Final Rx field (the left-eye subjective sphere is named "srosph").
                    var pairs = {
                        srodsph: 'fodsph', srodcyl: 'fodcyl', srodaxis: 'fodaxis', srodva: 'fodva', srodadd: 'fodadd', srodnva: 'fodnva',
                        srosph: 'fossph', sroscyl: 'foscyl', srosaxis: 'fosaxis', srosva: 'fosva', srosadd: 'fosadd', srosnva: 'fosnva'
                    };
                    Object.keys(pairs).forEach(function (name) {
                        var from = form.elements[name], to = form.elements[pairs[name]];
                        if (from && to && !to.value && from.value) { to.value = from.value; }
                    });
                    form.dispatchEvent(new Event('input'));
                });

                // Lock the Save button after the first click so a double click can't save twice.
                form.addEventListener('submit', function () {
                    dirty = false;
                    saveButton.disabled = true;
                    saveButton.querySelector('span').textContent = 'Saving…';
                });

                // Warn before leaving with an exam that was not saved.
                window.addEventListener('beforeunload', function (event) {
                    if (dirty) { event.preventDefault(); event.returnValue = ''; }
                });

                // If the browser restores this page from history (Back button), unlock the button again.
                // The one-time form token still stops the same exam being saved a second time.
                window.addEventListener('pageshow', function (event) {
                    if (event.persisted) {
                        saveButton.disabled = false;
                        saveButton.querySelector('span').textContent = saveButton.dataset.label;
                    }
                });
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
