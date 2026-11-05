{{-- Zone E: read-only facts to keep in view while working on this patient. --}}
@props(['chart'])
@php
    $visit = $chart->latestVisit();
    $treatment = $chart->latestTreatment();
    $summary = $chart->patient->summary;
@endphp
<x-clinical.panel title="Last examination">
    @if (! $visit)
        <p class="text-sm text-slate-600">No examinations recorded.</p>
    @else
        <p class="text-sm font-medium text-slate-900">{{ $visit['date']?->format('d-M-Y') }}</p>
        @if ($visit['complaint'])
            <p class="mt-1 text-sm text-slate-700"><span class="text-slate-500">Complaint:</span> {{ \Illuminate\Support\Str::limit($visit['complaint'], 120) }}</p>
        @endif

        <dl class="mt-3 grid grid-cols-[auto_1fr_1fr] gap-x-3 gap-y-1 text-sm">
            <dt class="sr-only">Measure</dt>
            <dd class="text-xs font-semibold uppercase text-slate-500"></dd>
            <dd class="text-xs font-semibold uppercase text-slate-500">OD</dd>
            <dd class="text-xs font-semibold uppercase text-slate-500">OS</dd>

            <dt class="text-slate-500">VA (unaided)</dt>
            <dd>{{ $visit['va']['OD'] ?? '-' }}</dd>
            <dd>{{ $visit['va']['OS'] ?? '-' }}</dd>

            <dt class="text-slate-500">IOP</dt>
            <dd>{{ $visit['iop']['OD'] ?? '-' }}</dd>
            <dd>{{ $visit['iop']['OS'] ?? '-' }}</dd>
        </dl>
        @if ($visit['iop'] && $visit['iopTakenAt'])
            <p class="mt-1 text-xs text-slate-500">IOP taken {{ $visit['iopTakenAt']->format('d-M-Y g:i A') }}</p>
        @endif
    @endif
</x-clinical.panel>

<x-clinical.panel title="Last final Rx">
    @if (! ($visit['rx'] ?? null))
        <p class="text-sm text-slate-600">No final Rx recorded.</p>
    @else
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-500">
                <tr><th class="pb-1 font-semibold"></th><th class="pb-1 font-semibold">Sph</th><th class="pb-1 font-semibold">Cyl</th><th class="pb-1 font-semibold">Axis</th><th class="pb-1 font-semibold">Add</th><th class="pb-1 font-semibold">VA</th></tr>
            </thead>
            <tbody>
                @foreach (['OD', 'OS'] as $eye)
                    @php $row = $visit['rx'][$eye]; @endphp
                    <tr>
                        <th scope="row" class="py-0.5 pr-2 font-semibold text-slate-600">{{ $eye }}</th>
                        <td>{{ $row['sph'] ?? '-' }}</td>
                        <td>{{ $row['cyl'] ?? '-' }}</td>
                        <td>{{ $row['axis'] ?? '-' }}</td>
                        <td>{{ $row['add'] ?? '-' }}</td>
                        <td>{{ $row['va'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-clinical.panel>

<x-clinical.panel title="Last treatment">
    @if (! $treatment)
        <p class="text-sm text-slate-600">No treatment plans recorded.</p>
    @else
        <p class="text-sm font-medium text-slate-900">{{ $treatment->created_at?->format('d-M-Y') }}</p>
        @foreach (['prescription' => 'Prescription', 'dosage' => 'Dosage', 'tab' => 'Tab', 'gutt' => 'Gutt', 'oc' => 'OC', 'sur' => 'Sur', 'rtc' => 'RTC', 'remark' => 'Remark'] as $field => $label)
            @if (filled($treatment->$field))
                <p class="mt-1 text-sm text-slate-700"><span class="text-slate-500">{{ $label }}:</span> {{ \Illuminate\Support\Str::limit((string) $treatment->$field, 140) }}</p>
            @endif
        @endforeach
    @endif
</x-clinical.panel>

@if (filled($summary))
    <x-clinical.panel title="Summary">
        <p class="whitespace-pre-line text-sm text-slate-700">{{ \Illuminate\Support\Str::limit($summary, 300) }}</p>
    </x-clinical.panel>
@endif
