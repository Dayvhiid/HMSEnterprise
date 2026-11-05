<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('clinic.name') }} · {{ config('clinic.product_name') }}</title>
    <style>
        :root{--ink:#0f2a3d;--muted:#4e6b80;--accent:#2a6f97;--bg:#f4f7fa;--card:#fff}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.55 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
        header{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:18px 24px;background:var(--ink);color:#fff}
        header .brand{font-weight:700;font-size:18px}
        header .brand small{display:block;font-weight:400;font-size:12px;color:#b9d2e3}
        header a{color:#fff;text-decoration:none;border:1px solid rgba(255,255,255,.4);padding:7px 14px;border-radius:6px}
        main{max-width:960px;margin:0 auto;padding:56px 16px}
        h1{font-size:34px;line-height:1.2;margin:0 0 12px}
        .lead{color:var(--muted);font-size:18px;max-width:620px;margin:0 0 32px}
        .actions{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:48px}
        .btn{display:inline-block;padding:12px 22px;border-radius:8px;text-decoration:none;font-weight:600}
        .btn-primary{background:var(--accent);color:#fff}
        .btn-secondary{background:#e1ecf4;color:var(--ink)}
        .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}
        .card{background:var(--card);border-radius:12px;padding:20px;box-shadow:0 1px 4px rgba(15,42,61,.08)}
        .card h3{margin:0 0 6px;font-size:16px}
        .card p{margin:0;color:var(--muted);font-size:14px}
        footer{max-width:960px;margin:0 auto;padding:24px 16px 40px;color:var(--muted);font-size:13px;border-top:1px solid #dbe5ec}
    </style>
</head>
<body>
<header>
    <div class="brand">{{ config('clinic.name') }}<small>{{ config('clinic.tagline') }}</small></div>
    @auth
        <a href="{{ route('dashboard') }}">Open {{ config('clinic.product_name') }}</a>
    @else
        <a href="{{ route('login') }}">Staff sign in</a>
    @endauth
</header>
<main>
    <h1>Welcome to {{ config('clinic.name') }}</h1>
    <p class="lead">Book an eye examination online, or sign in as a member of staff to manage patients, examinations, prescriptions, optical orders and billing.</p>
    <div class="actions">
        <a class="btn btn-primary" href="{{ route('booking') }}">Book an appointment</a>
        @guest
            <a class="btn btn-secondary" href="{{ route('login') }}">Staff sign in</a>
        @endguest
    </div>
    <div class="grid">
        <div class="card"><h3>Eye examinations</h3><p>Visual acuity, refraction, IOP and full anterior and posterior segment examination.</p></div>
        <div class="card"><h3>Spectacles &amp; lenses</h3><p>Prescriptions passed straight to the optician, with frame and lens stock tracked.</p></div>
        <div class="card"><h3>Treatment plans</h3><p>Medication, procedures and follow-up kept on each patient's record.</p></div>
        <div class="card"><h3>Appointments</h3><p>Request a visit online and we will call to confirm your time.</p></div>
    </div>
</main>
<footer>
    {{ config('clinic.name') }} · {{ config('clinic.address') }} · {{ config('clinic.phone') }} · {{ config('clinic.email') }}<br>
    Powered by {{ config('clinic.product_name') }}
</footer>
</body>
</html>
