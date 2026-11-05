{{-- Zone C: sections of one patient's chart. Same items in the same order on every chart screen. --}}
@props(['chart', 'active' => null])
@php
    $pid = $chart->patient->patient_id;
    $sections = [
        'overview' => ['label' => 'Overview', 'url' => route('patient.show', $chart->patient->id)],
        'details' => ['label' => 'Personal details', 'url' => route('patient.edit', $chart->patient->id)],
        'vitals' => ['label' => 'Examinations', 'url' => route('vitals.get', ['query' => $pid])],
        'treatment' => ['label' => 'Treatment & Rx', 'url' => route('search.get', ['query' => $pid])],
        'invoices' => ['label' => 'Invoices', 'url' => route('invoice.find', ['query' => $pid])],
    ];
    $new = [
        ['label' => 'Record examination', 'url' => route('doctors.vitals', ['patient' => $pid])],
        ['label' => 'New treatment plan', 'url' => route('doctors.treatment', ['patient' => $pid])],
        ['label' => 'Create invoice', 'url' => route('generate.show', ['patient' => $pid])],
    ];
@endphp
<div class="rounded-lg border border-slate-200 bg-white p-2 shadow-sm">
    <p class="px-2 pb-1 pt-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Chart</p>
    <ul class="space-y-0.5">
        @foreach ($sections as $key => $section)
            <li>
                <a href="{{ $section['url'] }}"
                   @if ($active === $key) aria-current="page" @endif
                   @class([
                       'block rounded-md px-3 py-2 text-sm font-medium',
                       'bg-sky-50 text-sky-800' => $active === $key,
                       'text-slate-700 hover:bg-slate-50' => $active !== $key,
                   ])>{{ $section['label'] }}</a>
            </li>
        @endforeach
    </ul>
    <p class="mt-3 border-t border-slate-100 px-2 pb-1 pt-3 text-xs font-semibold uppercase tracking-wide text-slate-500">New</p>
    <ul class="space-y-0.5">
        @foreach ($new as $item)
            <li><a href="{{ $item['url'] }}" class="block rounded-md px-3 py-2 text-sm font-medium text-sky-700 hover:bg-sky-50">+ {{ $item['label'] }}</a></li>
        @endforeach
    </ul>
</div>
