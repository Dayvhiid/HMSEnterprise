{{-- Patient chart: examinations. Every visit is its own form (PUT vitals.update); newest first, newest open.
     Six-zone clinical layout (ADR-005). $chart is null when no registered patient has this ID. --}}
@php
    $eyes = ['Right eye (OD)', 'Left eye (OS)'];
    $caseHistory = [
        // Labels match the entry form (doctors.newVitals); column names are historical.
        'cc' => 'Chief complaint (C/C)',
        'pohx' => 'Past ocular history',
        'lee' => 'Last eye exam',
        'pmhx' => 'Past medical history',
        'pfohx' => 'Past family ocular history',
    ];
@endphp
<x-layouts.clinical :title="'Examinations'.($chart ? ' - '.$chart->name() : '')">
    @if ($chart)
        <x-slot:banner><x-clinical.patient-banner :chart="$chart" /></x-slot:banner>
        <x-slot:nav><x-clinical.chart-nav :chart="$chart" active="vitals" /></x-slot:nav>
        <x-slot:context><x-clinical.patient-context :chart="$chart" /></x-slot:context>
    @endif

    <div class="flex flex-wrap items-end justify-between gap-2">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Examinations</h1>
            <p class="text-sm text-slate-600">
                Patient {{ $patientCode }}: {{ $visits->count() }} {{ \Illuminate\Support\Str::plural('visit', $visits->count()) }}, newest first
            </p>
        </div>
        @if ($visits->count() > 1)
            <div class="no-print flex gap-2 text-sm">
                <button type="button" class="font-medium text-sky-700 hover:underline" data-visits="open">Expand all</button>
                <span aria-hidden="true" class="text-slate-300">|</span>
                <button type="button" class="font-medium text-sky-700 hover:underline" data-visits="close">Collapse all</button>
            </div>
        @endif
    </div>

    @unless ($chart)
        <div role="status" class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            No registered patient has the ID {{ $patientCode }}. Use the search bar to find the right patient.
        </div>
    @endunless

    @if ($visits->isNotEmpty())
        <p class="text-sm text-slate-600">Open a visit to correct it, then click <strong>Save changes to this visit</strong>. Each visit saves separately.</p>
    @endif

    @forelse ($visits as $visit)
        @php
            $vital = $visit['vital'];
            $leftEye = $visit['vital2']; // left-eye subjective refraction and final Rx for this visit
            $id = $vital->id;
            // One-line summary in the collapsed header: right / left, blank when neither eye was recorded.
            $pair = fn ($od, $os) => filled($od) || filled($os) ? (filled($od) ? $od : '-').' / '.(filled($os) ? $os : '-') : null;
            $quick = array_filter([
                'VA' => $pair($vital->odunaided, $vital->osunaided),
                'IOP' => $pair($vital->odnct ?: $vital->odccct, $vital->osnct ?: $vital->oscct),
                'Final Rx sph' => $pair($vital->fodsph, $leftEye?->fossph),
            ]);
        @endphp
        <details class="vitals-visit group rounded-lg border border-slate-200 bg-white shadow-sm" @if ($loop->first) open @endif>
            <summary class="flex cursor-pointer list-none flex-wrap items-center gap-x-4 gap-y-1 rounded-lg px-4 py-3 hover:bg-slate-50 [&::-webkit-details-marker]:hidden">
                <span aria-hidden="true" class="text-slate-400 transition group-open:rotate-90">&#9656;</span>
                <span class="font-semibold text-slate-900">Visit: {{ $vital->created_at->format('F j, Y g:i A') }}</span>
                @if ($loop->first)
                    <span class="rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-800">Latest</span>
                @endif
                @if ($vital->updated_at && $vital->updated_at->gt($vital->created_at))
                    <span class="text-xs text-slate-500">Edited on {{ $vital->updated_at->format('F j, Y g:i A') }}</span>
                @endif
                <span class="ml-auto flex flex-wrap gap-x-4 text-xs text-slate-600">
                    @foreach ($quick as $label => $value)
                        <span><span class="font-semibold text-slate-500">{{ $label }} OD/OS</span> {{ $value }}</span>
                    @endforeach
                </span>
            </summary>

            <form method="POST" action="{{ route('vitals.update', $vital) }}" class="vitals-card-form space-y-6 border-t border-slate-100 p-4">
                @csrf
                @method('PUT')

                <div class="no-print flex flex-wrap items-center justify-end gap-3 text-sm">
                    <a href="{{ route('vitals.prescription', $vital) }}" target="_blank" class="font-medium text-sky-700 hover:underline">Print spectacle Rx</a>
                    <a href="{{ route('vitals.edit', $vital) }}" class="font-medium text-sky-700 hover:underline">Open in full form</a>
                    <button type="submit" class="vitals-card-save btn-primary"><span>Save changes to this visit</span></button>
                </div>

                <fieldset>
                    <legend class="mb-2 text-sm font-semibold text-slate-800">Case history</legend>
                    <div class="grid gap-3 md:grid-cols-2">
                        @foreach ($caseHistory as $name => $label)
                            <div @class(['md:col-span-2' => $name === 'cc'])>
                                <label for="{{ $name }}-{{ $id }}" class="field-label">{{ $label }}</label>
                                <textarea id="{{ $name }}-{{ $id }}" name="{{ $name }}" rows="{{ $name === 'cc' ? 3 : 2 }}" class="field-input">{{ $vital->$name }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </fieldset>

                <div class="grid gap-6 xl:grid-cols-2">
                    <x-clinical.exam-grid title="Visual acuity" :columns="['Unaided', 'Pin hole', 'Near VA']" :rows="[
                        $eyes[0] => ['ODunaided' => $vital->odunaided, 'ODpinhole' => $vital->odpinhole, 'ODnearVA' => $vital->odaxis],
                        $eyes[1] => ['OSunaided' => $vital->osunaided, 'OSpinhole' => $vital->ospinhole, 'OSnearVA' => $vital->osaxis],
                    ]" />

                    <x-clinical.exam-grid title="Lensometry" :columns="['Sph', 'Cyl', 'Axis', 'VA']" :rows="[
                        $eyes[0] => ['ODSPH' => $vital->lodsph, 'ODCYL' => $vital->lodcyl, 'ODAXIS' => $vital->lodaxis, 'ODVA' => $vital->lodva],
                        $eyes[1] => ['OSSPH' => $vital->lossph, 'OSCYL' => $vital->loscyl, 'OSAXIS' => $vital->losaxis, 'OSVA' => $vital->losva],
                        'ADD' => ['ADDSPH' => $vital->addsph, 'ADDCYL' => $vital->addcyl, 'ADDAXIS' => $vital->addaxis, 'ADDVA' => $vital->addva],
                    ]" />

                    <x-clinical.exam-grid title="Auto-refraction" :columns="['Sph', 'Cyl', 'Axis']" :rows="[
                        $eyes[0] => ['arodsph' => $vital->arodsphere, 'arodcyl' => $vital->arodcyl, 'arodaxis' => $vital->arodaxis],
                        $eyes[1] => ['arosph' => $vital->arossphere, 'aroscyl' => $vital->aroscyl, 'arosaxis' => $vital->arosaxis],
                    ]">
                        <p class="mt-2 flex items-center gap-2 text-sm text-slate-700">
                            <label for="arpd-{{ $id }}" class="font-medium">P.D. (Pupillary Distance):</label>
                            <input id="arpd-{{ $id }}" name="arpd" type="number" step="any" min="40" max="85" value="{{ $vital->arpd }}" class="field-input w-28 py-1.5" /> mm
                        </p>
                    </x-clinical.exam-grid>

                    <x-clinical.exam-grid title="Retinoscopy" :columns="['Sph', 'Cyl', 'Axis']" :rows="[
                        $eyes[0] => ['rodsph' => $vital->rodsph, 'rodcyl' => $vital->rodcyl, 'rodaxis' => $vital->rodaxis],
                        $eyes[1] => ['rossph' => $vital->rossph, 'roscyl' => $vital->roscyl, 'rosaxis' => $vital->rosaxis],
                    ]" />
                </div>

                <x-clinical.exam-grid title="Subjective refraction" :columns="['Sph', 'Cyl', 'Axis', 'VA', 'Add', 'Near VA']" :rows="[
                    $eyes[0] => ['srodsph' => $vital->srodsphere, 'srodcyl' => $vital->srodcyl, 'srodaxis' => $vital->srodaxis, 'srodva' => $vital->srodva, 'srodadd' => $vital->srodadd, 'srodnva' => $vital->srodnva],
                    $eyes[1] => ['srosph' => $leftEye?->srosphere, 'sroscyl' => $leftEye?->sroscyl, 'srosaxis' => $leftEye?->srosaxis, 'srosva' => $leftEye?->srosva, 'srosadd' => $leftEye?->srosadd, 'srosnva' => $leftEye?->srosnva],
                ]" />

                <div class="rounded-md border border-sky-200 bg-sky-50/50 p-3">
                    <x-clinical.exam-grid title="Final Rx" :columns="['Sph', 'Cyl', 'Axis', 'VA', 'Add', 'Near VA']" :rows="[
                        $eyes[0] => ['fodsph' => $vital->fodsph, 'fodcyl' => $vital->fodcyl, 'fodaxis' => $vital->fodaxis, 'fodva' => $vital->fodva, 'fodadd' => $vital->fodadd, 'fodnva' => $vital->fodnva],
                        $eyes[1] => ['fossph' => $leftEye?->fossph, 'foscyl' => $leftEye?->foscyl, 'fosaxis' => $leftEye?->fosaxis, 'fosva' => $leftEye?->fosva, 'fosadd' => $leftEye?->fosadd, 'fosnva' => $leftEye?->fosnva],
                    ]" />
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_minmax(0,2fr)]">
                    <x-clinical.exam-grid title="IOP" :columns="['NCT', 'CCT']" :rows="[
                        $eyes[0] => ['odnct' => $vital->odnct, 'odccct' => $vital->odccct],
                        $eyes[1] => ['osnct' => $vital->osnct, 'oscct' => $vital->oscct],
                    ]">
                        <p class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-700">
                            <label for="iop-{{ $id }}" class="font-medium">IOP taken:</label>
                            <input id="iop-{{ $id }}" name="iop_taken_at" type="datetime-local" value="{{ $vital->iop_taken_at?->format('Y-m-d\TH:i') }}" class="field-input w-auto py-1.5" />
                        </p>
                    </x-clinical.exam-grid>

                    <x-clinical.exam-grid title="External and internal examination" :columns="['Right eye (OD)', 'Left eye (OS)']" :rows="[
                        'Eyelid' => ['eyelidod' => $vital->eyelidod, 'eyelidos' => $vital->eyelidos],
                        'Conjunctiva' => ['conjuctivaod' => $vital->conjuctivaod, 'conjuctivaos' => $vital->conjuctivaos],
                        'Cornea' => ['corneaod' => $vital->corneaod, 'corneaos' => $vital->corneaos],
                        'Pupil' => ['pupilod' => $vital->pupilod, 'pupilos' => $vital->pupilos],
                        'Iris' => ['irisod' => $vital->irisod, 'irisos' => $vital->irisos],
                        'Lens' => ['lensod' => $vital->lensod, 'lensos' => $vital->lensos],
                        'Vitreous' => ['vitreousod' => $vital->vitreousod, 'vitreousos' => $vital->vitreousos],
                        'C/D ratio' => ['cdratiood' => $vital->cdratiood, 'cdratioos' => $vital->cdratioos],
                        'Macula' => ['macularod' => $vital->macularod, 'maculaos' => $vital->maculaos],
                    ]" />
                </div>

                <div class="no-print flex justify-end border-t border-slate-100 pt-4">
                    <button type="submit" class="vitals-card-save btn-primary"><span>Save changes to this visit</span></button>
                </div>
            </form>
        </details>
    @empty
        <x-clinical.panel>
            <p class="text-sm text-slate-600">No vitals recorded for this patient.</p>
        </x-clinical.panel>
    @endforelse

    <x-slot:actions>
        @if ($chart)
            <a href="{{ route('patient.show', $chart->patient->id) }}" class="btn-secondary">Back to overview</a>
        @endif
        <a href="{{ route('doctors.vitals', ['patient' => $patientCode]) }}" class="btn-primary">Record new examination</a>
    </x-slot:actions>

    <x-slot:scripts>
        <script>
            (function () {
                var dirty = false;
                document.querySelectorAll('[data-visits]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        var open = button.getAttribute('data-visits') === 'open';
                        document.querySelectorAll('details.vitals-visit').forEach(function (d) { d.open = open; });
                    });
                });
                document.querySelectorAll('.vitals-card-form').forEach(function (form) {
                    // Enter in a single-line field moves to the next field instead of saving the visit.
                    form.addEventListener('keydown', function (event) {
                        if (event.key !== 'Enter' || event.target.tagName !== 'INPUT') {
                            return;
                        }
                        event.preventDefault();
                        var fields = Array.prototype.filter.call(form.elements, function (el) {
                            return (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') && el.type !== 'hidden' && !el.disabled;
                        });
                        var next = fields[fields.indexOf(event.target) + 1];
                        if (next) {
                            next.focus();
                        }
                    });
                    form.addEventListener('input', function () { dirty = true; });
                    // Lock this card's Save button after the first click so a double click can't save twice.
                    form.addEventListener('submit', function () {
                        dirty = false;
                        form.querySelectorAll('.vitals-card-save').forEach(function (button) {
                            button.disabled = true;
                            button.querySelector('span').textContent = 'Saving…';
                        });
                    });
                });
                // Warn before leaving the page with edits that were not saved.
                window.addEventListener('beforeunload', function (event) {
                    if (dirty) {
                        event.preventDefault();
                        event.returnValue = '';
                    }
                });
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
