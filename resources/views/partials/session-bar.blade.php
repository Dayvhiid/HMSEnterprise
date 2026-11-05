{{-- Top bar shared by every screen (zone A of the EMR layout): product name, environment badge,
     universal search, module links, signed-in user and Log out.
     Styles are inline and prefixed "sb-" so they don't clash with each page's own Bootstrap/Tailwind CSS. --}}
@auth
@php
    $sbUser = auth()->user();
    $sbLinks = \App\Support\Modules::modules($sbUser);
    $sbEnv = config('clinic.environment');
@endphp
<style>
    .sb-wrap{position:sticky;top:0;z-index:1000}
    .sb-env{display:inline-flex;align-items:center;gap:6px;padding:2px 10px;border:1px solid rgba(251,191,36,.55);border-radius:999px;background:rgba(251,191,36,.12);color:#fcd34d;font:600 11px/1.5 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;letter-spacing:.3px;white-space:nowrap}
    .sb-env::before{content:"";width:6px;height:6px;border-radius:50%;background:#fbbf24}
    .sb-bar{display:flex;flex-wrap:wrap;align-items:center;gap:6px 16px;padding:8px 16px;background:#0f2a3d;color:#e8f1f7;font:500 13px/1.3 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;box-shadow:0 1px 3px rgba(0,0,0,.2)}
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
    .sb-search{position:relative;flex:0 1 320px;min-width:200px}
    .sb-bar .sb-search input{box-sizing:border-box;width:100%;height:30px;margin:0;padding:4px 44px 4px 10px;border:1px solid #2c5d80;border-radius:6px;background:#173a52;color:#fff;font:inherit;outline:none}
    .sb-bar .sb-search input::placeholder{color:#9fbdd3}
    .sb-bar .sb-search input:focus{border-color:#7cc4f5;background:#1d4664;box-shadow:0 0 0 2px rgba(124,196,245,.35)}
    .sb-kbd{position:absolute;right:8px;top:50%;transform:translateY(-50%);font-size:11px;color:#9fbdd3;border:1px solid #2c5d80;border-radius:4px;padding:0 5px;pointer-events:none}
    .sb-bar .sb-results{position:absolute;left:0;right:0;top:34px;max-height:70vh;overflow:auto;background:#fff;color:#0f172a;border-radius:8px;box-shadow:0 8px 24px rgba(15,42,61,.25);padding:6px 0;display:none}
    .sb-bar .sb-results.sb-open{display:block}
    .sb-bar .sb-results h6{margin:6px 12px 2px;font:700 11px/1.4 system-ui,sans-serif;text-transform:uppercase;letter-spacing:.5px;color:#64748b}
    .sb-bar .sb-results a{display:block;color:#0f172a !important;padding:7px 12px;border-radius:0}
    .sb-bar .sb-results a:hover,.sb-results a.sb-hl{background:#e0f2fe}
    .sb-bar .sb-results small{display:block;color:#64748b;font-size:12px}
    .sb-bar .sb-results p{margin:8px 12px;color:#64748b}
    @media print{.sb-wrap{display:none}}
</style>
<div class="sb-wrap">
<div class="sb-bar" role="navigation" aria-label="Main">
    <a class="sb-brand" href="{{ route($sbUser->homeRoute()) }}">{{ config('clinic.product_name') }}</a>
    @unless ($sbEnv['is_live'])
        {{-- Non-production copies are always labelled, as a badge next to the product name. --}}
        <span class="sb-env" role="status" data-environment="{{ $sbEnv['label'] }}">{{ $sbEnv['label'] }}</span>
    @endunless
    <form class="sb-search" method="GET" action="{{ route('search.global') }}" role="search" autocomplete="off">
        <label for="sb-q" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Search patients or screens</label>
        <input id="sb-q" name="q" type="search" value="{{ request()->routeIs('search.global') ? request('q') : '' }}"
               placeholder="Search patient name, ID, phone or screen" aria-controls="sb-results" aria-expanded="false">
        <span class="sb-kbd" aria-hidden="true">Ctrl K</span>
        <div id="sb-results" class="sb-results" role="listbox"></div>
    </form>
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
</div>
<script>
(function () {
    var input = document.getElementById('sb-q');
    var box = document.getElementById('sb-results');
    if (!input || !box) return;
    var url = @json(route('search.global'));
    var timer = null, seq = 0, items = [], hl = -1;

    function esc(s) { var d = document.createElement('div'); d.textContent = s == null ? '' : String(s); return d.innerHTML; }
    function close() { box.classList.remove('sb-open'); input.setAttribute('aria-expanded', 'false'); hl = -1; }
    function highlight(i) {
        items.forEach(function (el, n) { el.classList.toggle('sb-hl', n === i); });
        hl = i;
        if (items[i]) items[i].scrollIntoView({ block: 'nearest' });
    }
    function render(data, q) {
        var html = '';
        if (data.patients.length) {
            html += '<h6>Patients</h6>';
            data.patients.forEach(function (p) {
                html += '<a role="option" href="' + esc(p.url) + '">' + esc(p.name) +
                    '<small>' + esc(p.patient_id) + (p.gender ? ' · ' + esc(p.gender) : '') + (p.phone ? ' · ' + esc(p.phone) : '') + '</small></a>';
            });
        }
        if (data.actions.length) {
            html += '<h6>Screens</h6>';
            data.actions.forEach(function (a) { html += '<a role="option" href="' + esc(a.url) + '">' + esc(a.label) + '</a>'; });
        }
        if (!html) html = '<p>No patients or screens match “' + esc(q) + '”.</p>';
        html += '<a role="option" href="' + url + '?q=' + encodeURIComponent(q) + '"><small>See all results for “' + esc(q) + '” (Enter)</small></a>';
        box.innerHTML = html;
        items = Array.prototype.slice.call(box.querySelectorAll('a'));
        hl = -1;
        box.classList.add('sb-open');
        input.setAttribute('aria-expanded', 'true');
    }
    function lookup() {
        var q = input.value.trim();
        if (q.length < 2) { close(); return; }
        var mine = ++seq;
        fetch(url + '?q=' + encodeURIComponent(q), { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
            .then(function (r) { if (!r.ok) throw new Error('Search failed (' + r.status + ')'); return r.json(); })
            .then(function (data) { if (mine === seq) render(data, q); })
            .catch(function (err) {
                if (mine !== seq) return;
                box.innerHTML = '<p>Search is unavailable right now. Press Enter to try the full search page.</p>';
                items = []; box.classList.add('sb-open');
                if (window.console) console.error(err);
            });
    }
    input.addEventListener('input', function () { clearTimeout(timer); timer = setTimeout(lookup, 200); });
    input.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowDown' && items.length) { e.preventDefault(); highlight(Math.min(hl + 1, items.length - 1)); }
        else if (e.key === 'ArrowUp' && items.length) { e.preventDefault(); highlight(Math.max(hl - 1, 0)); }
        else if (e.key === 'Enter' && hl >= 0 && items[hl]) { e.preventDefault(); window.location = items[hl].href; }
        else if (e.key === 'Escape') { close(); input.blur(); }
    });
    document.addEventListener('click', function (e) { if (!e.target.closest || !e.target.closest('.sb-search')) close(); });
    document.addEventListener('keydown', function (e) {
        var typing = /^(INPUT|TEXTAREA|SELECT)$/.test(document.activeElement && document.activeElement.tagName) || (document.activeElement && document.activeElement.isContentEditable);
        if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) { e.preventDefault(); input.focus(); input.select(); }
        else if (e.key === '/' && !typing) { e.preventDefault(); input.focus(); }
    });
})();
</script>
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
