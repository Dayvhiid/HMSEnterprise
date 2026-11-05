{{-- Module sub-navigation: the few screens of one module, shown under the page title.
     $tabs: [label => route name]. The tab whose route is current is highlighted. --}}
@props(['tabs', 'label' => 'Section'])
<nav aria-label="{{ $label }}" class="no-print flex flex-wrap gap-1 border-b border-slate-200">
    @foreach ($tabs as $text => $route)
        @php $active = request()->routeIs($route); @endphp
        <a href="{{ route($route) }}" @if ($active) aria-current="page" @endif
           @class([
               '-mb-px border-b-2 px-3 py-2 text-sm font-medium',
               'border-sky-700 text-sky-800' => $active,
               'border-transparent text-slate-600 hover:border-slate-300 hover:text-slate-900' => ! $active,
           ])>{{ $text }}</a>
    @endforeach
</nav>
