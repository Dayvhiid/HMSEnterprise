{{-- Optician: dispensing records, searchable and paged. Also shown for /optician/find and /optician/search. --}}
<x-layouts.clinical title="Dispensing records">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Dispensing</h1>
            <p class="text-sm text-slate-600">Spectacles dispensed, newest first. Search by patient ID or name.</p>
        </div>
        <a href="{{ route('optician.records') }}" class="btn-primary">+ New records</a>
    </div>

    <x-clinical.tabs label="Dispensing" :tabs="['New records' => 'optician.records', 'Records list' => 'optician.list']" />

    <form method="GET" action="{{ route('optician.list') }}" role="search" class="flex flex-wrap items-center gap-3 rounded-lg border border-slate-200 bg-white p-3 shadow-sm">
        <label for="optician-query" class="sr-only">Search dispensing records</label>
        <input id="optician-query" name="query" type="search" value="{{ $query }}" autofocus placeholder="Patient ID or name" class="field-input max-w-md flex-1">
        <button type="submit" class="btn-secondary">Search</button>
        @if ($query !== '')
            <a href="{{ route('optician.list') }}" class="text-sm font-medium text-sky-700 hover:underline">Clear</a>
        @endif
    </form>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        @if ($records->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium text-slate-900">{{ $query !== '' ? 'No records match “'.$query.'”.' : 'No dispensing records yet.' }}</p>
                <p class="mt-1 text-sm text-slate-600"><a href="{{ route('optician.records') }}" class="font-medium text-sky-700 hover:underline">Enter new records</a></p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th scope="col" class="px-4 py-2.5">Date</th>
                            <th scope="col" class="px-4 py-2.5">Patient ID</th>
                            <th scope="col" class="px-4 py-2.5">Patient name</th>
                            <th scope="col" class="px-4 py-2.5">Power</th>
                            <th scope="col" class="px-4 py-2.5">Frame type</th>
                            <th scope="col" class="px-4 py-2.5 text-right">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach ($records as $record)
                            <tr class="hover:bg-slate-50">
                                <td class="whitespace-nowrap px-4 py-2.5">{{ $record->date ? \Carbon\Carbon::parse($record->date)->format('d-M-Y') : '-' }}</td>
                                {{-- card_number holds the Patient ID; older rows may hold a paper card number instead. --}}
                                <td class="whitespace-nowrap px-4 py-2.5 font-mono text-xs">
                                    @if (isset($chartIds[$record->card_number]))
                                        <a href="{{ route('patient.show', $chartIds[$record->card_number]) }}" class="font-medium text-sky-700 hover:underline">{{ $record->card_number }}</a>
                                    @else
                                        {{ filled($record->card_number) ? $record->card_number : '-' }}
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 font-medium text-slate-900">{{ $record->patient_name }}</td>
                                <td class="px-4 py-2.5">{{ filled($record->power) ? $record->power : '-' }}</td>
                                <td class="px-4 py-2.5">{{ filled($record->frame_type) ? $record->frame_type : '-' }}</td>
                                <td class="px-4 py-2.5 text-right tabular-nums">{{ filled($record->qty) ? $record->qty : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-clinical.pager :paginator="$records" noun="record" />
        @endif
    </div>
</x-layouts.clinical>
