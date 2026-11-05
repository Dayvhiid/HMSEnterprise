{{-- Printable spectacle prescription (Final RX) for one visit. Only recorded values are shown; nothing is filled in. --}}
@php
    $patientName = $patient ? (trim($patient->first_name.' '.$patient->last_name) ?: $patient->fullname) : null;
    $age = null;
    if ($patient) {
        try {
            $age = $patient->date ? \Carbon\Carbon::parse($patient->date)->age : null;
        } catch (\Throwable $e) {
            $age = null;
        }
        $age ??= $patient->age;
    }
    $show = fn ($v) => filled($v) ? $v : '—';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spectacle prescription · {{ $vital->patient_code }} · {{ config('clinic.product_name') }}</title>
    <style>
        @page{size:A5;margin:12mm}
        body{margin:0;background:#f4f7fa;color:#111;font:14px/1.45 system-ui,-apple-system,"Segoe UI",Roboto,sans-serif}
        .rx{max-width:680px;margin:24px auto;background:#fff;padding:28px 32px;box-shadow:0 1px 6px rgba(0,0,0,.08)}
        .rx-head{display:flex;justify-content:space-between;gap:16px;border-bottom:2px solid #0f2a3d;padding-bottom:12px;margin-bottom:16px}
        .rx-clinic{font-size:20px;font-weight:700;color:#0f2a3d}
        .rx-contact{font-size:12px;color:#444;text-align:right}
        h1{font-size:16px;letter-spacing:.5px;text-transform:uppercase;margin:0 0 12px;color:#0f2a3d}
        .rx-meta{display:grid;grid-template-columns:1fr 1fr;gap:4px 24px;margin-bottom:18px}
        .rx-meta span{color:#555}
        table{width:100%;border-collapse:collapse;margin-bottom:14px}
        th,td{border:1px solid #9aa9b4;padding:8px;text-align:center}
        th{background:#eef3f7;font-size:12px;text-transform:uppercase}
        td.eye{text-align:left;font-weight:600}
        .rx-empty{padding:12px;background:#fff7e0;border-radius:6px;margin-bottom:14px}
        .rx-sign{display:flex;justify-content:space-between;gap:24px;margin-top:40px}
        .rx-sign div{flex:1;border-top:1px solid #333;padding-top:4px;font-size:12px;color:#444}
        .rx-actions{max-width:680px;margin:0 auto 32px;display:flex;gap:8px}
        .rx-actions button,.rx-actions a{padding:9px 16px;border-radius:6px;border:0;background:#e1ecf4;color:#0f2a3d;font-weight:600;text-decoration:none;cursor:pointer;font-size:14px}
        .rx-actions .primary{background:#0f2a3d;color:#fff}
        @media print{body{background:#fff}.rx{box-shadow:none;margin:0;max-width:none;padding:0}.rx-actions{display:none}}
    </style>
</head>
<body>
@include('partials.session-bar', ['showErrors' => false])
<div class="rx">
    <div class="rx-head">
        <div>
            <div class="rx-clinic">{{ config('clinic.name') }}</div>
            <div style="font-size:12px;color:#444;">{{ config('clinic.tagline') }}</div>
        </div>
        <div class="rx-contact">{{ config('clinic.address') }}<br>{{ config('clinic.phone') }}<br>{{ config('clinic.email') }}</div>
    </div>

    <h1>Spectacle prescription</h1>
    <div class="rx-meta">
        <div><span>Patient:</span> {{ $patientName ?? '—' }}</div>
        <div><span>Date of exam:</span> {{ $vital->created_at->format('d M Y') }}</div>
        <div><span>Patient ID:</span> {{ $vital->patient_code }}</div>
        <div><span>Age / sex:</span> {{ $age ?? '—' }}{{ $patient?->gender ? ' / '.ucfirst($patient->gender) : '' }}</div>
    </div>

    @if ($hasRx)
        <table>
            <thead>
                <tr><th></th><th>Sphere</th><th>Cylinder</th><th>Axis</th><th>VA</th><th>Add</th><th>Near VA</th></tr>
            </thead>
            <tbody>
                @foreach ($rx as $eyeLabel => $values)
                    <tr>
                        <td class="eye">{{ $eyeLabel }}</td>
                        <td>{{ $show($values['sph']) }}</td>
                        <td>{{ $show($values['cyl']) }}</td>
                        <td>{{ $show($values['axis']) }}</td>
                        <td>{{ $show($values['va']) }}</td>
                        <td>{{ $show($values['add']) }}</td>
                        <td>{{ $show($values['nva']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="rx-empty">No final prescription (Final RX) was recorded for this visit. Add it on the exam form before printing.</div>
    @endif

    <div><span style="color:#555;">Pupillary distance (P.D.):</span> {{ filled($vital->arpd) ? $vital->arpd.' mm' : '—' }}</div>

    <div class="rx-sign">
        <div>Prescribed by (name)</div>
        <div>Signature &amp; stamp</div>
    </div>
</div>
<div class="rx-actions">
    <button type="button" class="primary" onclick="window.print()" @disabled(! $hasRx)>Print</button>
    <a href="{{ route('vitals.get', ['query' => $vital->patient_code]) }}">Back to visits</a>
</div>
</body>
</html>
