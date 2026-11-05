{{-- Patient chart: treatment plans & Rx, then the exam sections taken at each visit.
     Six-zone clinical layout (ADR-005). $chart is null when no registered patient has this ID. --}}
@php
    $medicationFields = ['dosage' => 'Dosage', 'duration' => 'Duration', 'tab' => 'Tab', 'gutt' => 'Gutt', 'oc' => 'OC', 'sur' => 'Sur', 'rtc' => 'RTC'];
    $lensFields = ['single_vision' => 'Single vision', 'bifocal' => 'Bifocal', 'progressive' => 'Progressive', 'invisible' => 'Invisible', 'special_order' => 'Special order'];
    $lensChoices = function ($treatment, string $field): ?string {
        $decoded = json_decode((string) $treatment->$field);

        return $decoded ? implode(', ', (array) $decoded) : null;
    };
@endphp
<x-layouts.clinical :title="'Treatment & Rx'.($chart ? ' - '.$chart->name() : '')">
    @if ($chart)
        <x-slot:banner><x-clinical.patient-banner :chart="$chart" /></x-slot:banner>
        <x-slot:nav><x-clinical.chart-nav :chart="$chart" active="treatment" /></x-slot:nav>
        <x-slot:context><x-clinical.patient-context :chart="$chart" /></x-slot:context>
    @endif

    <div>
        <h1 class="text-xl font-semibold text-slate-900">Treatment &amp; Rx</h1>
        <p class="text-sm text-slate-600">
            Patient {{ $patientId }}: {{ $treatments->count() }} treatment {{ \Illuminate\Support\Str::plural('plan', $treatments->count()) }}, newest first
        </p>
    </div>

    @unless ($chart)
        <div role="status" class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            No registered patient has the ID {{ $patientId }}. Use the search bar to find the right patient.
        </div>
    @endunless

    @forelse ($treatments as $treatment)
        @php $lenses = collect($lensFields)->map(fn ($label, $field) => $lensChoices($treatment, $field))->filter(); @endphp
        <x-clinical.panel :title="\Carbon\Carbon::parse($treatment->created_at)->format('F j, Y g:i A')">
            @if ($loop->first)
                <x-slot:headerActions><span class="rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-800">Latest</span></x-slot:headerActions>
            @endif

            <div class="grid gap-4 lg:grid-cols-2">
                <div>
                    <h3 class="mb-1 text-sm font-semibold text-slate-800">Prescription</h3>
                    <p class="whitespace-pre-line rounded-md border border-slate-200 bg-slate-50 p-3 text-sm text-slate-900">{{ filled(trim((string) $treatment->prescription)) ? trim($treatment->prescription) : 'None recorded' }}</p>
                </div>
                <div>
                    <h3 class="mb-1 text-sm font-semibold text-slate-800">Lens type</h3>
                    @if ($lenses->isEmpty())
                        <p class="text-sm text-slate-600">None recorded</p>
                    @else
                        <dl class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-1 text-sm">
                            @foreach ($lenses as $field => $choices)
                                <dt class="text-slate-500">{{ $lensFields[$field] }}</dt>
                                <dd class="text-slate-900">{{ $choices }}</dd>
                            @endforeach
                        </dl>
                    @endif
                </div>
            </div>

            <dl class="mt-4 grid grid-cols-2 gap-x-6 gap-y-3 border-t border-slate-100 pt-4 text-sm sm:grid-cols-4 xl:grid-cols-7">
                @foreach ($medicationFields as $field => $label)
                    <div>
                        <dt class="text-slate-500">{{ $label }}</dt>
                        <dd class="whitespace-pre-line text-slate-900">{{ filled($treatment->$field) ? $treatment->$field : '-' }}</dd>
                    </div>
                @endforeach
            </dl>

            <div class="mt-4 border-t border-slate-100 pt-4 text-sm">
                <p class="text-slate-500">Remark</p>
                <p class="whitespace-pre-line text-slate-900">{{ filled($treatment->remark) ? $treatment->remark : '-' }}</p>
            </div>
        </x-clinical.panel>
    @empty
        <x-clinical.panel>
            <p class="text-sm text-slate-600">No treatment plans recorded for this patient.</p>
        </x-clinical.panel>
    @endforelse

    <x-clinical.panel title="Examinations Taken" id="examinations">
        <div class="space-y-4">
            @forelse ($examinations as $exam)
                <div>
                    <p class="pb-2 text-sm font-medium text-slate-900">{{ \Carbon\Carbon::parse($exam['date'])->format('F j, Y g:i A') }}</p>
                    <ul class="flex flex-wrap gap-2">
                        @foreach ($exam['sections'] as $section => $taken)
                            <li @class([
                                'flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium',
                                'bg-green-100 text-green-800' => $taken,
                                'bg-slate-100 text-slate-500' => ! $taken,
                            ])>
                                <span aria-hidden="true">{{ $taken ? '✓' : '–' }}</span>
                                <span>{{ $section }}</span>
                                <span class="sr-only">{{ $taken ? '(taken)' : '(not taken)' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-sm text-slate-600">No examinations recorded for this patient.</p>
            @endforelse
        </div>
    </x-clinical.panel>

    <x-slot:actions>
        @if ($chart)
            <a href="{{ route('patient.show', $chart->patient->id) }}" class="btn-secondary">Back to overview</a>
        @endif
        <a href="{{ route('doctors.treatment', ['patient' => $patientId]) }}" class="btn-primary">New treatment plan</a>
    </x-slot:actions>
</x-layouts.clinical>
