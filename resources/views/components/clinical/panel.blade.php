{{-- A titled card for the workspace or context column. --}}
@props(['title' => null, 'id' => null])
<section @if ($id) id="{{ $id }}" @endif {{ $attributes->merge(['class' => 'scroll-mt-48 rounded-lg border border-slate-200 bg-white shadow-sm']) }}>
    @if ($title || isset($headerActions))
        <header class="flex items-center justify-between gap-3 border-b border-slate-100 px-4 py-3">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-600">{{ $title }}</h2>
            {{ $headerActions ?? '' }}
        </header>
    @endif
    <div class="p-4">
        {{ $slot }}
    </div>
</section>
