{{-- Thermal-printer receipt for one invoice. Totals come from Invo::totals(), the same maths as the reports. --}}
@php
    $totals = $invoice->totals();
    $money = fn ($n) => '₦'.number_format((float) $n, 2);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Receipt {{ $invoice->receiptNumber() }} · {{ config('clinic.product_name') }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body{margin:0;background:#fff;color:#000;font-family:'Courier New',Courier,monospace;font-size:14px}
        .receipt{width:384px;margin:0 auto;padding:10px;box-sizing:border-box}
        .center{text-align:center;margin-bottom:6px}
        .line{border-top:1px dashed #000;margin:8px 0}
        table{width:100%;border-collapse:collapse;font-size:14px}
        th,td{text-align:left;padding:2px 0;vertical-align:top}
        .right{text-align:right}
        .bold{font-weight:bold}
        .note{font-size:12px;margin-top:10px}
        .invoice-btns{width:384px;margin:12px auto 32px;display:flex;gap:8px;flex-wrap:wrap;font-family:system-ui,sans-serif}
        .invoice-btns a,.invoice-btns button{flex:1;text-align:center;padding:9px 10px;border-radius:6px;border:0;font:600 14px system-ui,sans-serif;text-decoration:none;cursor:pointer;background:#e1ecf4;color:#0f2a3d}
        .invoice-btns .primary{background:#0f2a3d;color:#fff}
        @media print{.invoice-btns{display:none}}
    </style>
</head>
<body>
@include('partials.session-bar', ['showErrors' => false])
<div class="receipt" id="receipt">
    <div class="center bold">{{ strtoupper(config('clinic.name')) }}</div>
    <div class="center">{{ config('clinic.address') }}</div>
    <div class="center">{{ config('clinic.phone') }}</div>
    <div class="line"></div>
    <div class="center bold">RECEIPT {{ $invoice->receiptNumber() }}</div>
    <div>Date: {{ $invoice->created_at?->format('d M Y, H:i') }}</div>
    <div>Patient ID: {{ $invoice->pid }}</div>
    @if ($patient)
        <div>Patient: {{ trim($patient->first_name.' '.$patient->last_name) ?: $patient->fullname }}</div>
    @endif
    <div class="line"></div>
    <table>
        <thead>
            <tr><th>Item</th><th class="right">Rate</th><th class="right">Qty</th><th class="right">Amount</th></tr>
        </thead>
        <tbody>
            @foreach ($invoice->lines() as $line)
                <tr>
                    <td>{{ $line['name'] }}</td>
                    <td class="right">{{ number_format($line['price'], 2) }}</td>
                    <td class="right">{{ $line['qty'] }}</td>
                    <td class="right">{{ number_format($line['subtotal'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="line"></div>
    <table>
        <tr><td>Subtotal</td><td class="right">{{ $money($totals['gross']) }}</td></tr>
        @if ($totals['discount'] > 0)
            <tr><td>Discount ({{ rtrim(rtrim(number_format($invoice->discountPercent(), 2), '0'), '.') }}%)</td><td class="right">-{{ $money($totals['discount']) }}</td></tr>
        @endif
        <tr class="bold"><td>TOTAL</td><td class="right">{{ $money($totals['net']) }}</td></tr>
    </table>
    <div class="line"></div>
    <div class="note center">Thank you for choosing {{ config('clinic.name') }}.</div>
</div>
<div class="invoice-btns">
    <button type="button" class="primary" onclick="window.print()">Print</button>
    <button type="button" id="downloadPdfBtn">Download PDF</button>
    <a href="{{ route('generate.show') }}">New invoice</a>
</div>
<script>
    document.getElementById('downloadPdfBtn').addEventListener('click', function () {
        if (typeof html2pdf === 'undefined') { window.print(); return; }
        html2pdf().set({
            margin: 5,
            filename: @json('receipt-'.$invoice->receiptNumber().'.pdf'),
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a5', orientation: 'portrait' }
        }).from(document.getElementById('receipt')).save();
    });
</script>
</body>
</html>
