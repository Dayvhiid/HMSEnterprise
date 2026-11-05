{{-- Billing: find invoices. Clinical layout (ADR-005). Filters are a GET form (shareable URLs);
     typing or changing a filter updates the results in place, Enter works without JavaScript. --}}
@php
    $money = fn ($n) => '₦'.number_format((float) $n, 2);
    $periods = ['today' => 'Today', 'week' => 'Last 7 days', 'month' => 'This month'];
    $filtered = $query !== '' || $range['from'] || $range['to'];
@endphp
<x-layouts.clinical title="Find invoice">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Billing</h1>
            <p class="text-sm text-slate-600">Find an invoice to view or reprint its receipt.</p>
        </div>
        <a href="{{ route('generate.show') }}" class="btn-primary">+ New invoice</a>
    </div>

    <x-clinical.tabs label="Billing" :tabs="['New invoice' => 'generate.show', 'Find invoice' => 'invoice.find']" />

    <form id="invoice-filters" method="GET" action="{{ route('invoice.find') }}" role="search"
          class="space-y-3 rounded-lg border border-slate-200 bg-white p-3 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[16rem] flex-1">
                <label for="invoice-query" class="sr-only">Search invoices</label>
                <div class="relative">
                    <svg aria-hidden="true" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.47 9.77l3.63 3.63a.75.75 0 1 0 1.06-1.06l-3.63-3.63A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/></svg>
                    <input id="invoice-query" name="query" type="search" value="{{ $query }}" autocomplete="off" autofocus
                           placeholder="Patient name, Patient ID or receipt number (e.g. RCT-000042)" class="field-input pl-9">
                </div>
            </div>
            <div>
                <label for="invoice-from" class="field-label text-xs">From</label>
                <input id="invoice-from" name="from" type="date" value="{{ $range['from'] }}" class="field-input">
            </div>
            <div>
                <label for="invoice-to" class="field-label text-xs">To</label>
                <input id="invoice-to" name="to" type="date" value="{{ $range['to'] }}" class="field-input">
            </div>
            <input type="hidden" name="period" value="{{ $range['period'] }}" id="invoice-period">
            <noscript><button type="submit" class="btn-secondary">Apply</button></noscript>
        </div>
        <div class="flex flex-wrap items-center gap-2 text-sm">
            <span class="text-xs font-medium uppercase tracking-wide text-slate-500">Quick:</span>
            @foreach ($periods as $key => $label)
                <button type="button" data-period="{{ $key }}" @class([
                    'rounded-full border px-3 py-1 font-medium',
                    'border-sky-600 bg-sky-50 text-sky-800' => $range['period'] === $key,
                    'border-slate-300 bg-white text-slate-700 hover:bg-slate-50' => $range['period'] !== $key,
                ])>{{ $label }}</button>
            @endforeach
            <a href="{{ route('invoice.find') }}" class="ml-auto font-medium text-sky-700 hover:underline">Reset</a>
        </div>
    </form>

    <div id="invoice-results" aria-live="polite" class="space-y-4">
        <dl class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            @foreach ([
                ['Invoices', number_format($summary['count'])],
                ['Total billed', $money($summary['net'])],
                ['Discounts given', $money($summary['discount'])],
            ] as [$label, $value])
                <div class="rounded-lg border border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $label }}</dt>
                    <dd class="mt-1 text-xl font-semibold tabular-nums text-slate-900">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            @if ($invoices->isEmpty())
                <div class="px-6 py-12 text-center">
                    <p class="text-sm font-medium text-slate-900">{{ $filtered ? 'No invoices match these filters.' : 'No invoices yet.' }}</p>
                    <p class="mt-1 text-sm text-slate-600">
                        @if ($filtered)
                            Try part of the name, the Patient ID or the receipt number, or <a href="{{ route('invoice.find') }}" class="font-medium text-sky-700 hover:underline">clear the filters</a>.
                        @else
                            <a href="{{ route('generate.show') }}" class="font-medium text-sky-700 hover:underline">Create the first invoice</a>.
                        @endif
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                            <tr>
                                <th scope="col" class="px-4 py-2.5">Receipt</th>
                                <th scope="col" class="px-4 py-2.5">Date</th>
                                <th scope="col" class="px-4 py-2.5">Patient</th>
                                <th scope="col" class="px-4 py-2.5">Items</th>
                                <th scope="col" class="px-4 py-2.5 text-right">Discount</th>
                                <th scope="col" class="px-4 py-2.5 text-right">Total</th>
                                <th scope="col" class="px-4 py-2.5 text-right"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach ($invoices as $invoice)
                                @php
                                    $patient = $patients[$invoice->pid] ?? null;
                                    $lines = $invoice->lines();
                                    $totals = $invoice->totals();
                                    $receiptUrl = route('invoice.show', ['id' => $invoice->id]);
                                @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="whitespace-nowrap px-4 py-2.5">
                                        <a href="{{ $receiptUrl }}" class="font-mono text-xs font-semibold text-sky-700 hover:underline">{{ $invoice->receiptNumber() }}</a>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2.5">
                                        {{ $invoice->created_at?->format('d-M-Y') }}
                                        <span class="block text-xs text-slate-500">{{ $invoice->created_at?->format('g:i A') }}</span>
                                    </td>
                                    <td class="px-4 py-2.5">
                                        @if ($patient)
                                            <a href="{{ route('patient.show', $patient->id) }}" class="font-medium text-slate-900 hover:text-sky-700">{{ $patient->displayName() }}</a>
                                            <span class="block font-mono text-xs text-slate-500">{{ $patient->patient_id }}</span>
                                        @elseif (filled($invoice->pid))
                                            <span class="font-medium text-slate-900">{{ $invoice->pid }}</span>
                                            <span class="block text-xs text-slate-500">Not a registered patient</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2.5">
                                        @foreach (array_slice($lines, 0, 2) as $line)
                                            <span class="block">{{ $line['qty'] }} × {{ $line['name'] }}</span>
                                        @endforeach
                                        @if (count($lines) > 2)
                                            <span class="block text-xs text-slate-500">+ {{ count($lines) - 2 }} more</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2.5 text-right tabular-nums">
                                        {{ $invoice->discountPercent() > 0 ? rtrim(rtrim(number_format($invoice->discountPercent(), 2), '0'), '.').'%' : '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2.5 text-right font-semibold tabular-nums text-slate-900">{{ $money($totals['net']) }}</td>
                                    <td class="whitespace-nowrap px-4 py-2.5 text-right">
                                        <a href="{{ $receiptUrl }}" class="rounded-md border border-slate-300 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">View receipt</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-clinical.pager :paginator="$invoices" noun="invoice" />
            @endif
        </div>
    </div>

    <x-slot:scripts>
        <script>
            (function () {
                var form = document.getElementById('invoice-filters');
                var period = document.getElementById('invoice-period');
                var timer = null, seq = 0;

                function apply() {
                    var url = form.action + '?' + new URLSearchParams(new FormData(form)).toString();
                    var mine = ++seq;
                    fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'text/html' } })
                        .then(function (r) { if (!r.ok) throw new Error('Invoice list failed (' + r.status + ')'); return r.text(); })
                        .then(function (html) {
                            if (mine !== seq) return;
                            var doc = new DOMParser().parseFromString(html, 'text/html');
                            var fresh = doc.getElementById('invoice-results');
                            if (!fresh) { window.location = url; return; }
                            document.getElementById('invoice-results').replaceWith(fresh);
                            // Keep the date boxes and chips in step with a preset the server worked out.
                            ['invoice-from', 'invoice-to'].forEach(function (id) { document.getElementById(id).value = doc.getElementById(id).value; });
                            form.querySelectorAll('[data-period]').forEach(function (b) {
                                b.className = doc.querySelector('[data-period="' + b.dataset.period + '"]').className;
                            });
                            history.replaceState(null, '', url);
                        })
                        .catch(function (err) { if (window.console) console.error(err); window.location = url; });
                }

                form.querySelectorAll('[data-period]').forEach(function (b) {
                    b.addEventListener('click', function () {
                        period.value = period.value === b.dataset.period ? '' : b.dataset.period; // click again to turn off
                        if (!period.value) { document.getElementById('invoice-from').value = ''; document.getElementById('invoice-to').value = ''; }
                        apply();
                    });
                });
                form.addEventListener('input', function (e) {
                    if (e.target.type === 'date') period.value = ''; // typing a date replaces the preset
                    clearTimeout(timer);
                    timer = setTimeout(apply, e.target.type === 'search' ? 250 : 0);
                });
                form.addEventListener('submit', function (e) { e.preventDefault(); clearTimeout(timer); apply(); });
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
