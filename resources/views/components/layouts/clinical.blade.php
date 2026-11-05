{{-- Clinical screen layout: the six zones from the EMR UI guide.
       A  top bar          - partials.session-bar (search, modules, user, environment)
       B  $banner          - patient identity; stays visible while the page scrolls
       C  $nav             - chart sections (left column)
       D  default slot     - the task in progress (largest area)
       E  $context         - read-mostly facts needed while doing D (right column)
       F  $actions         - commit the work; primary action goes last (far right)
     Every slot except the default one is optional; columns only appear when filled. --}}
@props(['title' => null])
@php
    $hasNav = isset($nav) && $nav->isNotEmpty();
    $hasContext = isset($context) && $context->isNotEmpty();
    $columns = match (true) {
        $hasNav && $hasContext => 'lg:grid-cols-[13rem_minmax(0,1fr)_18rem]',
        $hasNav => 'lg:grid-cols-[13rem_minmax(0,1fr)]',
        $hasContext => 'lg:grid-cols-[minmax(0,1fr)_18rem]',
        default => 'lg:grid-cols-1',
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title.' - ' : '' }}{{ config('clinic.product_name') }}</title>
    @vite(['resources/css/clinical.css'])
    {{ $head ?? '' }}
</head>
<body class="min-h-screen">
    @include('partials.session-bar', ['showErrors' => false])

    @isset($banner)
        <div class="sticky top-[var(--sb-height,0px)] z-30 border-b border-slate-200 bg-white shadow-sm" data-zone="patient-banner">
            {{ $banner }}
        </div>
    @endisset

    <div class="mx-auto grid max-w-[1600px] gap-4 px-4 py-4 {{ $columns }}">
        @if ($hasNav)
            <nav class="no-print lg:sticky lg:top-4 lg:self-start" aria-label="Chart sections" data-zone="chart-nav">
                {{ $nav }}
            </nav>
        @endif

        <main class="min-w-0 space-y-4" data-zone="workspace">
            @if (session('success'))
                <div role="status" class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('info'))
                <div role="status" class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">{{ session('info') }}</div>
            @endif
            @if ($errors->any())
                <div role="alert" class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <p class="font-semibold">Please fix the following:</p>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>

        @if ($hasContext)
            <aside class="space-y-4 lg:sticky lg:top-4 lg:self-start" aria-label="Patient context" data-zone="context">
                {{ $context }}
            </aside>
        @endif
    </div>

    @isset($actions)
        <div class="no-print sticky bottom-0 z-30 border-t border-slate-200 bg-white/95 backdrop-blur" data-zone="action-bar">
            <div class="mx-auto flex max-w-[1600px] flex-wrap items-center justify-end gap-3 px-4 py-3">
                {{ $actions }}
            </div>
        </div>
    @endisset

    <script>
        // Keep the patient banner directly under the top bar, whatever height the bar wraps to.
        (function () {
            var bar = document.querySelector('.sb-wrap');
            if (!bar) return;
            function sync() { document.documentElement.style.setProperty('--sb-height', bar.offsetHeight + 'px'); }
            sync();
            window.addEventListener('resize', sync);
        })();
    </script>
    {{ $scripts ?? '' }}
</body>
</html>
