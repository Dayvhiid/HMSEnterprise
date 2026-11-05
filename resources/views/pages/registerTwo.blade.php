{{-- Front desk: register a new patient. Clinical layout (ADR-005). Field names and validation are unchanged
     (PagesController@store); typed values survive a failed save. --}}
@php
    // Suggested patient ID. A clash with an existing ID is rejected on save, so offer a fresh one then.
    $suggestedId = rand(1, 1000).'/'.date('m/Y');
    $patientId = $errors->has('pid') ? $suggestedId : old('pid', $suggestedId);

    $sections = [
        'Personal information' => [
            ['firstname', 'First name', 'text', 'given-name'],
            ['lastname', 'Last name', 'text', 'family-name'],
            ['dob', 'Date of birth', 'date', 'bday'],
            ['radio', 'Sex', 'select', 'sex'],
            ['occupation', 'Occupation', 'text', 'organization-title'],
        ],
        'Contact & address' => [
            ['phone', 'Phone', 'tel', 'tel'],
            ['email', 'Email', 'email', 'email'],
            ['street', 'Street address', 'text', 'street-address'],
            ['city', 'City', 'text', 'address-level2'],
            ['state', 'State', 'text', 'address-level1'],
        ],
        'Emergency contact' => [
            ['efn', 'Full name', 'text', 'off'],
            ['erel', 'Relationship', 'text', 'off'],
            ['epn', 'Phone', 'tel', 'off'],
            ['ee', 'Email', 'email', 'off'],
        ],
    ];
@endphp
<x-layouts.clinical title="Register patient">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Register patient</h1>
            <p class="text-sm text-slate-600">Enter the new patient's details. All fields are required.</p>
        </div>
        <div class="no-print flex gap-3">
            <button type="reset" form="register-patient" class="btn-secondary">Clear form</button>
            <button type="submit" form="register-patient" class="btn-primary register-submit">Register Patient</button>
        </div>
    </div>

    <form id="register-patient" method="POST" action="{{ route('pages.store') }}" class="space-y-4">
        @csrf

        @foreach ($sections as $section => $fields)
            <x-clinical.panel :title="$section">
                <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2 2xl:grid-cols-3">
                    @foreach ($fields as [$name, $label, $type, $autocomplete])
                        <div @class(['md:col-span-2 2xl:col-span-1' => $name === 'street'])>
                            <label for="{{ $name }}" class="field-label">{{ $label }}</label>
                            @if ($type === 'select')
                                <select id="{{ $name }}" name="{{ $name }}" required class="field-input">
                                    <option value="">Select</option>
                                    @foreach (['male' => 'Male', 'female' => 'Female'] as $value => $text)
                                        <option value="{{ $value }}" @selected(old($name) === $value)>{{ $text }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" required
                                       autocomplete="{{ $autocomplete }}" @if ($type === 'date') max="{{ now()->toDateString() }}" @endif
                                       @class(['field-input', 'border-red-400' => $errors->has($name)])>
                            @endif
                            @error($name)<p class="pt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </x-clinical.panel>
        @endforeach

        <x-clinical.panel title="Patient ID">
            <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 2xl:grid-cols-3">
                <div>
                    <label for="pid" class="field-label">Patient ID</label>
                    <input type="text" id="pid" name="pid" value="{{ $patientId }}" class="field-input font-mono">
                    <p class="pt-1 text-xs text-slate-500">Suggested automatically. Change it only to match an existing paper card number.</p>
                    @error('pid')<p class="pt-1 text-sm text-red-700">{{ $message }} A new ID has been suggested.</p>@enderror
                </div>
            </div>
        </x-clinical.panel>
    </form>

    <x-slot:context>
        <x-clinical.panel title="Before you register">
            <p class="text-sm text-slate-700">Check the patient is not already on file. Search by name, phone or ID.</p>
            <button type="button" class="btn-secondary mt-3 w-full" data-focus-search>Search patients <span class="text-xs text-slate-400">Ctrl K</span></button>
        </x-clinical.panel>

        <x-clinical.panel title="Registered today">
            @forelse ($registeredToday as $patient)
                <a href="{{ route('patient.show', $patient->id) }}" class="-mx-2 block rounded-md px-2 py-1.5 hover:bg-slate-50">
                    <span class="block text-sm font-medium text-slate-900">{{ trim($patient->first_name.' '.$patient->last_name) ?: $patient->fullname }}</span>
                    <span class="block text-xs text-slate-500"><span class="font-mono">{{ $patient->patient_id }}</span> · {{ $patient->created_at?->format('g:i A') }}</span>
                </a>
            @empty
                <p class="text-sm text-slate-600">No patients registered yet today.</p>
            @endforelse
        </x-clinical.panel>

        <x-clinical.panel title="Front desk">
            <ul class="space-y-1 text-sm">
                <li><a href="{{ route('public.records') }}" class="font-medium text-sky-700 hover:underline">Patient records</a></li>
                <li><a href="{{ route('image.upload') }}" class="font-medium text-sky-700 hover:underline">Upload case file</a></li>
                <li><a href="{{ route('images.search') }}" class="font-medium text-sky-700 hover:underline">View case files</a></li>
                <li><a href="{{ route('generate.show') }}" class="font-medium text-sky-700 hover:underline">Generate invoice</a></li>
            </ul>
        </x-clinical.panel>
    </x-slot:context>

    <x-slot:actions>
        <button type="reset" form="register-patient" class="btn-secondary">Clear form</button>
        <button type="submit" form="register-patient" class="btn-primary register-submit">Register Patient</button>
    </x-slot:actions>

    <x-slot:scripts>
        <script>
            (function () {
                var form = document.getElementById('register-patient');
                document.querySelectorAll('[data-focus-search]').forEach(function (b) {
                    b.addEventListener('click', function () { var q = document.getElementById('sb-q'); if (q) { q.focus(); q.select(); } });
                });
                // One click registers once: lock both Register buttons while the form is sent.
                form.addEventListener('submit', function () {
                    document.querySelectorAll('.register-submit').forEach(function (b) { b.disabled = true; b.textContent = 'Registering…'; });
                });
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
