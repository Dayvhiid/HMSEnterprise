{{-- Shared result page used by pages.status and doctors.status.
     Shows the flashed message ('success' or 'msg'), styled by 'status_type' (success | error | info),
     with links back to the previous screen and to the user's home screen. No history.go(-1), so a form is never re-submitted. --}}
@php
    $message = session('success') ?? session('msg');
    $type = session('status_type') ?? (session()->has('success') ? 'success' : 'info');
    $palette = [
        'success' => ['bg' => '#e8f6ee', 'border' => '#2e9b5f', 'text' => '#14532d', 'icon' => '✓', 'heading' => 'Done'],
        'error' => ['bg' => '#fdecea', 'border' => '#c62828', 'text' => '#7f1d1d', 'icon' => '!', 'heading' => 'Not completed'],
        'info' => ['bg' => '#e8f1f7', 'border' => '#2a6f97', 'text' => '#0f2a3d', 'icon' => 'i', 'heading' => 'Update'],
    ][$type] ?? null;
    $palette ??= ['bg' => '#e8f1f7', 'border' => '#2a6f97', 'text' => '#0f2a3d', 'icon' => 'i', 'heading' => 'Update'];
    $back = url()->previous();
    $home = auth()->check() ? route(auth()->user()->homeRoute()) : url('/');
    $continueUrl = session('next_url');
    $continueLabel = session('next_label', 'Continue');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $palette['heading'] }} · {{ config('clinic.product_name') }}</title>
    <style>
        body{margin:0;background:#f4f7fa;color:#0f2a3d;font:15px/1.5 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
        .oc-wrap{max-width:560px;margin:72px auto;padding:0 16px}
        .oc-card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(15,42,61,.08);padding:32px;text-align:center;border-top:4px solid {{ $palette['border'] }}}
        .oc-icon{width:52px;height:52px;border-radius:50%;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:700;background:{{ $palette['bg'] }};color:{{ $palette['border'] }}}
        .oc-card h1{margin:0 0 8px;font-size:20px}
        .oc-msg{margin:0 0 24px;color:{{ $palette['text'] }}}
        .oc-actions{display:flex;gap:10px;justify-content:center;flex-wrap:wrap}
        .oc-actions a{display:inline-block;padding:9px 18px;border-radius:6px;text-decoration:none;font-weight:600}
        .oc-primary{background:#0f2a3d;color:#fff}
        .oc-secondary{background:#e8f1f7;color:#0f2a3d}
    </style>
</head>
<body>
@include('partials.session-bar', ['showErrors' => false])
<div class="oc-wrap">
    <div class="oc-card">
        <div class="oc-icon" aria-hidden="true">{{ $palette['icon'] }}</div>
        <h1>{{ $palette['heading'] }}</h1>
        <p class="oc-msg">{{ $message ?? 'There is nothing new to show here.' }}</p>
        <div class="oc-actions">
            @if ($continueUrl)
                <a class="oc-primary" href="{{ $continueUrl }}">{{ $continueLabel }}</a>
            @endif
            @if ($back && $back !== url()->current())
                <a class="{{ $continueUrl ? 'oc-secondary' : 'oc-primary' }}" href="{{ $back }}">Back</a>
            @endif
            <a class="oc-secondary" href="{{ $home }}">Home</a>
        </div>
    </div>
</div>
</body>
</html>
