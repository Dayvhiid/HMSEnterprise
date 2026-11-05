{{-- Patient chart: overview. Six-zone clinical layout (ADR-005). --}}
@php
    $checkedInAt = $chart->checkedInToday();
    $address = collect([$user->street, $user->city, $user->state])->filter(fn ($part) => filled($part))->implode(', ');
    $emergency = collect([$user->emergency_fullname, filled($user->emergency_relationship) ? '('.$user->emergency_relationship.')' : null])->filter()->implode(' ');
@endphp
<x-layouts.clinical :title="$chart->name()">
    <x-slot:banner><x-clinical.patient-banner :chart="$chart" /></x-slot:banner>
    <x-slot:nav><x-clinical.chart-nav :chart="$chart" active="overview" /></x-slot:nav>
    <x-slot:context><x-clinical.patient-context :chart="$chart" /></x-slot:context>

    <h1 class="text-xl font-semibold text-slate-900">Overview</h1>

    <x-clinical.panel title="Medical Records" id="records">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            @foreach ([
                ['label' => 'Vitals', 'count' => $medicalRecords['vitalsCount'], 'latest' => $medicalRecords['latestVital'], 'route' => 'vitals.get', 'button' => 'View Vitals', 'empty' => 'No vitals recorded'],
                ['label' => 'Treatment Plans', 'count' => $medicalRecords['treatmentsCount'], 'latest' => $medicalRecords['latestTreatment'], 'route' => 'search.get', 'button' => 'View Treatment Plan', 'empty' => 'No treatment plans recorded'],
            ] as $record)
                <div class="flex flex-col justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 p-4">
                    <div>
                        <p class="text-base font-semibold text-slate-900">{{ $record['label'] }} ({{ $record['count'] }})</p>
                        <p class="text-sm text-slate-600">
                            @if ($record['latest'])
                                Latest: {{ \Carbon\Carbon::parse($record['latest'])->format('F j, Y') }}
                            @else
                                {{ $record['empty'] }}
                            @endif
                        </p>
                    </div>
                    @if ($record['count'] > 0)
                        <a href="{{ route($record['route'], ['query' => $user->patient_id]) }}" class="btn-secondary">{{ $record['button'] }}</a>
                    @endif
                </div>
            @endforeach
        </div>
    </x-clinical.panel>

    <x-clinical.panel title="Patient Summary" id="summary">
        <div class="rounded-md border border-slate-200 bg-slate-50 p-3">
            @if (filled($user->summary))
                <p class="whitespace-pre-line text-sm leading-relaxed text-slate-900">{{ $user->summary }}</p>
            @else
                <p class="text-sm italic text-slate-600">No summary yet.</p>
            @endif
            @if ($user->summary_updated_at)
                <p class="pt-3 text-xs text-slate-500">
                    Last updated by {{ $user->summary_updated_by }} on {{ $user->summary_updated_at->format('F j, Y \a\t g:i A') }}
                </p>
            @endif
        </div>
        <form method="POST" action="{{ route('patient.summary.update', $user->id) }}" class="pt-3">
            @csrf
            @method('PUT')
            <label for="summary" class="field-label">Write or edit the summary</label>
            <textarea id="summary" name="summary" rows="5" maxlength="5000"
                      placeholder="e.g. Diagnosis, ongoing treatment, allergies, follow-up notes..."
                      class="field-input">{{ old('summary', $user->summary) }}</textarea>
            @error('summary')
                <p class="pt-1 text-sm text-red-700">{{ $message }}</p>
            @enderror
            <button type="submit" class="btn-secondary mt-2">Save Summary</button>
        </form>
    </x-clinical.panel>

    <x-clinical.panel title="Patient Information" id="details">
        <x-slot:headerActions>
            <a href="{{ route('patient.edit', $user->id) }}" class="text-sm font-medium text-sky-700 hover:underline">Edit</a>
        </x-slot:headerActions>
        <dl class="grid grid-cols-1 gap-x-6 gap-y-3 text-sm sm:grid-cols-2">
            @foreach ([
                'Address' => $address,
                'Phone' => $user->phone,
                'Email' => $user->email,
                'Occupation' => $user->occupation,
                'Emergency Contact Name' => $emergency,
                'Emergency Contact Phone' => $user->emergency_phone,
                'Registered' => $user->created_at?->format('F j, Y'),
                'Last Visit' => $user->datee,
            ] as $label => $value)
                <div class="border-t border-slate-100 pt-2">
                    <dt class="text-slate-500">{{ $label }}</dt>
                    <dd class="text-slate-900">{{ filled($value) ? $value : '-' }}</dd>
                </div>
            @endforeach
        </dl>
    </x-clinical.panel>

    <x-slot:actions>
        <a href="{{ route('patient.edit', $user->id) }}" class="btn-secondary">Update Details</a>
        @if ($checkedInAt)
            <button type="button" class="btn-primary" disabled>Checked in today at {{ $checkedInAt->format('g:i A') }}</button>
        @else
            <form method="POST" action="{{ route('patient.checkin', $user->id) }}">
                @csrf
                <button type="submit" class="btn-primary">Check In (Returning Patient)</button>
            </form>
        @endif
    </x-slot:actions>
</x-layouts.clinical>
