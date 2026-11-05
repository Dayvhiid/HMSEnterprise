{{-- Table footer for a length-aware paginator: "Showing 1–25 of 240 patients" and Previous / Next. --}}
@props(['paginator', 'noun' => 'result'])
<div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 bg-slate-50 px-4 py-2.5 text-xs text-slate-600">
    <span>Showing <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong> of <strong>{{ $paginator->total() }}</strong> {{ \Illuminate\Support\Str::plural($noun, $paginator->total()) }}</span>
    <div class="flex gap-2">
        @if ($paginator->onFirstPage())
            <span class="rounded-md border border-slate-200 bg-white px-3 py-1 text-slate-400">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-md border border-slate-300 bg-white px-3 py-1 font-medium text-slate-700 hover:bg-slate-100">Previous</a>
        @endif
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-md border border-slate-300 bg-white px-3 py-1 font-medium text-slate-700 hover:bg-slate-100">Next</a>
        @else
            <span class="rounded-md border border-slate-200 bg-white px-3 py-1 text-slate-400">Next</span>
        @endif
    </div>
</div>
