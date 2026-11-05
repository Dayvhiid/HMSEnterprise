<x-layouts.clinical title="Search">
    <div>
        <h1 class="text-xl font-semibold text-slate-900">Search</h1>
        <p class="text-sm text-slate-600">Find a patient by name, patient ID or phone number, or jump to a screen by name.</p>
    </div>

    <form method="GET" action="{{ route('search.global') }}" class="flex flex-wrap gap-2" role="search">
        <label for="q" class="sr-only">Search</label>
        <input id="q" name="q" type="search" value="{{ $query }}" autofocus
               class="field-input max-w-xl flex-1" placeholder="e.g. Ada Obi, 413/07/2026 or 0803 123 4567">
        <button type="submit" class="btn-primary">Search</button>
    </form>

    @if ($tooShort)
        <p class="text-sm text-slate-600">Type at least {{ $minLength }} characters to search.</p>
    @else
        <x-clinical.panel title="Patients ({{ $patients->count() }}{{ $patients->count() >= $limit ? '+' : '' }})">
            @if ($patients->isEmpty())
                <p class="text-sm text-slate-600">
                    No patient matches “{{ $query }}”.
                    <a href="{{ route('pages.register') }}" class="font-medium text-sky-700 underline">Register a new patient</a>
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="py-2 pr-4 font-semibold">Name</th>
                                <th class="py-2 pr-4 font-semibold">Patient ID</th>
                                <th class="py-2 pr-4 font-semibold">Sex</th>
                                <th class="py-2 pr-4 font-semibold">Age</th>
                                <th class="py-2 pr-4 font-semibold">Phone</th>
                                <th class="py-2 font-semibold"><span class="sr-only">Open</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($patients as $patient)
                                <tr class="hover:bg-sky-50">
                                    <td class="py-2 pr-4 font-medium text-slate-900">{{ $displayName($patient) }}</td>
                                    <td class="py-2 pr-4 font-mono text-slate-700">{{ $patient->patient_id }}</td>
                                    <td class="py-2 pr-4 capitalize">{{ $patient->gender }}</td>
                                    <td class="py-2 pr-4">{{ $patient->age }}</td>
                                    <td class="py-2 pr-4">{{ $patient->phone }}</td>
                                    <td class="py-2 text-right">
                                        <a href="{{ route('patient.show', $patient->id) }}" class="btn-secondary px-3 py-1">Open chart</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($patients->count() >= $limit)
                    <p class="mt-3 text-sm text-slate-600">Showing the first {{ $limit }} matches. Add more of the name or the full patient ID to narrow it down.</p>
                @endif
            @endif
        </x-clinical.panel>

        @if ($actions !== [])
            <x-clinical.panel title="Screens">
                <ul class="flex flex-wrap gap-2">
                    @foreach ($actions as $action)
                        <li><a href="{{ route($action['route']) }}" class="btn-secondary">{{ $action['label'] }}</a></li>
                    @endforeach
                </ul>
            </x-clinical.panel>
        @endif
    @endif
</x-layouts.clinical>
