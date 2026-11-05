{{-- Zone B: who this patient is. Shown on every patient screen; the name is never truncated. --}}
@props(['chart'])
@php
    $patient = $chart->patient;
    $dob = $chart->dateOfBirth();
    $checkedInAt = $chart->checkedInToday();
@endphp
<div class="mx-auto flex max-w-[1600px] flex-wrap items-center gap-x-6 gap-y-2 px-4 py-3" data-patient-id="{{ $patient->patient_id }}">
    <div class="min-w-0">
        <p class="break-words text-xl font-bold uppercase leading-tight tracking-wide text-slate-900">{{ $chart->name() }}</p>
        <p class="mt-0.5 flex flex-wrap gap-x-3 text-sm text-slate-700">
            <span>{{ $chart->sex() ?? 'Sex not recorded' }}</span>
            <span aria-hidden="true" class="text-slate-300">|</span>
            <span>{{ $chart->age() ?? 'Age not recorded' }}</span>
            <span aria-hidden="true" class="text-slate-300">|</span>
            <span>DOB {{ $dob ? $dob->format('d-M-Y') : 'not recorded' }}</span>
            <span aria-hidden="true" class="text-slate-300">|</span>
            <span>ID <span class="font-mono font-semibold text-slate-900">{{ $patient->patient_id }}</span></span>
            @if (filled($patient->phone))
                <span aria-hidden="true" class="text-slate-300">|</span>
                <span>{{ $patient->phone }}</span>
            @endif
        </p>
    </div>
    <div class="ml-auto flex flex-wrap items-center gap-2 text-sm">
        @if ($checkedInAt)
            <span class="rounded-full bg-green-100 px-3 py-1 font-medium text-green-800">Checked in today {{ $checkedInAt->format('g:i A') }}</span>
        @else
            <span class="rounded-full bg-slate-100 px-3 py-1 font-medium text-slate-600">Not checked in today</span>
        @endif
    </div>
</div>
