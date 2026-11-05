{{-- Top bar shared by the main screens: product name, module links, signed-in user and Log out.
     Styles are inline and prefixed "sb-" so they don't clash with each page's own Bootstrap/Tailwind CSS. --}}
@auth
@php
    $sbUser = auth()->user();
    $sbLinks = [
        ['label' => 'Front Desk', 'route' => 'pages.register'],
        ['label' => 'Patients', 'route' => 'public.records'],
        ['label' => 'Clinical', 'route' => 'doctors.index'],
        ['label' => 'Optician', 'route' => 'optician.index'],
        ['label' => 'Billing', 'route' => 'generate.show'],
        ['label' => 'Stock', 'route' => 'admin.admin2'],
    ];
    if ($sbUser->isAdmin()) {
        $sbLinks[] = ['label' => 'Admin', 'route' => 'admin.dashboard'];
    }
@endphp
<style>
    .sb-bar{position:sticky;top:0;z-index:1000;display:flex;flex-wrap:wrap;align-items:center;gap:6px 16px;padding:8px 16px;background:#0f2a3d;color:#e8f1f7;font:500 13px/1.3 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;box-shadow:0 1px 3px rgba(0,0,0,.2)}
    .sb-bar a{color:#cfe3f1;text-decoration:none;padding:4px 8px;border-radius:4px}
    .sb-bar a:hover{background:rgba(255,255,255,.1);color:#fff}
    .sb-bar a.sb-active{background:rgba(255,255,255,.18);color:#fff}
    .sb-brand{font-weight:700;color:#fff !important;letter-spacing:.2px;padding-left:0 !important}
    .sb-nav{display:flex;flex-wrap:wrap;gap:2px;flex:1 1 auto}
    .sb-user{display:flex;align-items:center;gap:10px;margin-left:auto}
    .sb-role{font-size:11px;background:#1f4b6b;color:#cfe3f1;padding:2px 8px;border-radius:10px}
    .sb-bar form{margin:0}
    .sb-bar button{font:inherit;color:#0f2a3d;background:#e8f1f7;border:0;border-radius:4px;padding:4px 10px;cursor:pointer}
    .sb-bar button:hover{background:#fff}
    @media print{.sb-bar{display:none}}
</style>
<div class="sb-bar" role="navigation" aria-label="Main">
    <a class="sb-brand" href="{{ route($sbUser->homeRoute()) }}">{{ config('clinic.product_name') }}</a>
    <nav class="sb-nav">
        @foreach ($sbLinks as $link)
            <a href="{{ route($link['route']) }}" @class(['sb-active' => request()->routeIs($link['route'])])>{{ $link['label'] }}</a>
        @endforeach
    </nav>
    <div class="sb-user">
        <span>{{ $sbUser->name }}</span>
        <span class="sb-role">{{ $sbUser->roleLabel() }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Log out</button>
        </form>
    </div>
</div>
@endauth
{{-- Validation errors for forms that don't show their own. Pages that do pass showErrors => false. --}}
@if (($showErrors ?? true) && isset($errors) && $errors->any())
<div role="alert" style="max-width:960px;margin:12px auto;padding:12px 16px;border-radius:8px;background:#fdecea;color:#8a1c1c;font:14px/1.4 system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;">
    <strong>Please fix the following:</strong>
    <ul style="margin:6px 0 0 18px;padding:0;">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif
