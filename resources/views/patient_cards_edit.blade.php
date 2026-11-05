{{-- Patient chart: personal details. Six-zone clinical layout (ADR-005). Field names are unchanged. --}}
@php
    $fields = [
        ['first_name', 'First name', 'text'],
        ['last_name', 'Last name', 'text'],
        ['gender', 'Gender', 'select'],
        ['age', 'Age', 'text'],
        ['phone', 'Phone', 'tel'],
        ['email', 'Email', 'email'],
        ['street', 'Address', 'text'],
        ['occupation', 'Occupation', 'text'],
    ];
    $emergency = [
        ['emergency_fullname', 'Contact name', 'text'],
        ['emergency_phone', 'Contact phone', 'tel'],
    ];
    // Stored values vary in case ("female"); match case-insensitively so saving never flips the patient's sex to the first option.
    $currentGender = (string) old('gender', $user->gender);
    $genders = collect(['Male', 'Female']);
    if (filled($currentGender) && ! $genders->contains(fn ($g) => strcasecmp($g, $currentGender) === 0)) {
        $genders->push($currentGender);
    }
@endphp
<x-layouts.clinical :title="'Edit details - '.$chart->name()">
    <x-slot:banner><x-clinical.patient-banner :chart="$chart" /></x-slot:banner>
    <x-slot:nav><x-clinical.chart-nav :chart="$chart" active="details" /></x-slot:nav>
    <x-slot:context><x-clinical.patient-context :chart="$chart" /></x-slot:context>

    <h1 class="text-xl font-semibold text-slate-900">Personal details</h1>

    <form id="patient-details" action="{{ route('patient.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        {{-- The update action also writes fullname; send the current value so saving this form does not erase it. --}}
        <input type="hidden" name="fullname" value="{{ $user->fullname }}">

        @foreach (['Patient' => $fields, 'Emergency contact' => $emergency] as $section => $sectionFields)
            <x-clinical.panel :title="$section">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach ($sectionFields as [$name, $label, $type])
                        <div>
                            <label for="{{ $name }}" class="field-label">{{ $label }}</label>
                            @if ($type === 'select')
                                <select id="{{ $name }}" name="{{ $name }}" class="field-input">
                                    @foreach ($genders as $option)
                                        <option value="{{ $option }}" @selected(strcasecmp($option, $currentGender) === 0)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $user->$name) }}" class="field-input">
                            @endif
                            @error($name)<p class="pt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </x-clinical.panel>
        @endforeach

        <x-clinical.panel title="Current status">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="datee" class="field-label">Last visit date</label>
                    <input type="date" id="datee" name="datee" value="{{ old('datee', $user->datee) }}" class="field-input">
                </div>
            </div>
        </x-clinical.panel>
    </form>

    <x-slot:actions>
        <a href="{{ route('patient.show', $user->id) }}" class="btn-secondary">Cancel</a>
        <button type="submit" form="patient-details" class="btn-primary">Save Changes</button>
    </x-slot:actions>
</x-layouts.clinical>
