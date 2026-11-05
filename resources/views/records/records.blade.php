{{-- Patients list. Clinical layout (ADR-005). Filters are a GET form, so every view is a shareable URL;
     typing filters the table in place (debounced), Enter does the same without JavaScript. --}}
<x-layouts.clinical title="Patients">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Patients</h1>
            <p class="text-sm text-slate-600">Find a patient by name, ID or phone, then open their chart.</p>
        </div>
        <a href="{{ route('pages.register') }}" class="btn-primary">+ Register new patient</a>
    </div>

    <form id="records-filters" method="GET" action="{{ route('public.records') }}" role="search"
          class="flex flex-wrap items-end gap-3 rounded-lg border border-slate-200 bg-white p-3 shadow-sm">
        <div class="min-w-[16rem] flex-1">
            <label for="records-query" class="sr-only">Search patients</label>
            <div class="relative">
                <svg aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.47 9.77l3.63 3.63a.75.75 0 1 0 1.06-1.06l-3.63-3.63A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/></svg>
                <input id="records-query" name="query" type="search" value="{{ $filters['query'] }}" autocomplete="off" autofocus
                       placeholder="Name, patient ID or phone" class="field-input pl-9">
            </div>
        </div>
        <div>
            <label for="records-sex" class="field-label text-xs">Sex</label>
            <select id="records-sex" name="sex" class="field-input">
                <option value="">All</option>
                <option value="female" @selected($filters['sex'] === 'female')>Female</option>
                <option value="male" @selected($filters['sex'] === 'male')>Male</option>
            </select>
        </div>
        <div>
            <label for="records-from" class="field-label text-xs">Registered from</label>
            <input id="records-from" name="from" type="date" value="{{ $filters['from'] }}" class="field-input">
        </div>
        <div>
            <label for="records-to" class="field-label text-xs">to</label>
            <input id="records-to" name="to" type="date" value="{{ $filters['to'] }}" class="field-input">
        </div>
        <div>
            <label for="records-sort" class="field-label text-xs">Sort</label>
            <select id="records-sort" name="sort" class="field-input">
                @foreach ($sorts as $value => $label)
                    <option value="{{ $value }}" @selected($filters['sort'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <label class="flex h-[38px] items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="checked_in" value="1" @checked($filters['checked_in']) class="rounded border-slate-300 text-sky-700 focus:ring-sky-600">
            Checked in today
        </label>
        <a href="{{ route('public.records') }}" class="flex h-[38px] items-center text-sm font-medium text-sky-700 hover:underline">Reset</a>
        <noscript><button type="submit" class="btn-secondary">Apply</button></noscript>
    </form>

    <div id="records-results" aria-live="polite" class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        @if ($patients->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium text-slate-900">
                    {{ $filtered ? 'No patients match these filters.' : 'No patients registered yet.' }}
                </p>
                <p class="mt-1 text-sm text-slate-600">
                    @if ($filtered)
                        Check the spelling, try part of the name or phone, or <a href="{{ route('public.records') }}" class="font-medium text-sky-700 hover:underline">clear the filters</a>.
                    @endif
                    If the patient is new, <a href="{{ route('pages.register') }}" class="font-medium text-sky-700 hover:underline">register them</a>.
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th scope="col" class="px-4 py-2.5">Patient</th>
                            <th scope="col" class="px-4 py-2.5">Patient ID</th>
                            <th scope="col" class="px-4 py-2.5">DOB / Age</th>
                            <th scope="col" class="px-4 py-2.5">Sex</th>
                            <th scope="col" class="px-4 py-2.5">Phone</th>
                            <th scope="col" class="px-4 py-2.5">Last exam</th>
                            <th scope="col" class="px-4 py-2.5">Today</th>
                            <th scope="col" class="px-4 py-2.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach ($patients as $patient)
                            @php
                                $chart = \App\Support\PatientChart::for($patient);
                                $name = $patient->displayName();
                                $initials = collect(preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY))->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
                                $dob = $chart->dateOfBirth();
                                $isCheckedIn = isset($checkedInToday[$patient->patient_id]);
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5">
                                    <a href="{{ route('patient.show', $patient->id) }}" class="flex items-center gap-3 font-medium text-slate-900 hover:text-sky-700">
                                        <span aria-hidden="true" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-xs font-semibold text-sky-800">{{ $initials ?: '?' }}</span>
                                        <span>{{ $name ?: 'Name not recorded' }}</span>
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5 font-mono text-xs text-slate-600">{{ $patient->patient_id }}</td>
                                <td class="whitespace-nowrap px-4 py-2.5">
                                    {{ $dob ? $dob->format('d-M-Y') : '-' }}
                                    @if ($chart->age())<span class="text-slate-500">({{ $chart->age() }})</span>@endif
                                </td>
                                <td class="px-4 py-2.5">{{ $chart->sex() ?? '-' }}</td>
                                <td class="whitespace-nowrap px-4 py-2.5">{{ filled($patient->phone) ? $patient->phone : '-' }}</td>
                                <td class="whitespace-nowrap px-4 py-2.5">{{ $patient->last_exam_at ? \Carbon\Carbon::parse($patient->last_exam_at)->format('d-M-Y') : 'None' }}</td>
                                <td class="px-4 py-2.5">
                                    @if ($isCheckedIn)
                                        <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Checked in</span>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('patient.show', $patient->id) }}" class="font-medium text-sky-700 hover:underline">View</a>
                                        <a href="{{ route('patient.edit', $patient->id) }}" class="text-slate-600 hover:underline">Edit</a>
                                        @unless ($isCheckedIn)
                                            <form method="POST" action="{{ route('patient.checkin', $patient->id) }}">
                                                @csrf
                                                <button type="submit" class="rounded-md border border-slate-300 bg-white px-2 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">Check in</button>
                                            </form>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-clinical.pager :paginator="$patients" noun="patient" />
        @endif
    </div>

    <x-slot:scripts>
        <script>
            // Filter as you type: fetch the same page with the new filters and swap in its results table.
            (function () {
                var form = document.getElementById('records-filters');
                var timer = null, seq = 0;
                function apply() {
                    var url = form.action + '?' + new URLSearchParams(new FormData(form)).toString();
                    var mine = ++seq;
                    fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'text/html' } })
                        .then(function (r) { if (!r.ok) throw new Error('Patient list failed (' + r.status + ')'); return r.text(); })
                        .then(function (html) {
                            if (mine !== seq) return;
                            var doc = new DOMParser().parseFromString(html, 'text/html');
                            var fresh = doc.getElementById('records-results');
                            if (!fresh) { window.location = url; return; }
                            document.getElementById('records-results').replaceWith(fresh);
                            history.replaceState(null, '', url);
                        })
                        .catch(function (err) { if (window.console) console.error(err); window.location = url; });
                }
                form.addEventListener('input', function (e) {
                    clearTimeout(timer);
                    timer = setTimeout(apply, e.target.type === 'search' ? 250 : 0);
                });
                form.addEventListener('submit', function (e) { e.preventDefault(); clearTimeout(timer); apply(); });
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
