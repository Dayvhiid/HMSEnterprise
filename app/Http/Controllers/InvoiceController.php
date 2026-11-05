<?php

namespace App\Http\Controllers;

use App\Models\Invo;
use App\Models\Test;
use App\Models\Drug;
use App\Models\Lens;
use App\Models\Frame;
use App\Models\Invoice;
use App\Models\PatientInfo;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{


      public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'nullable|string',
            'discount' => 'nullable|integer',
            'names' => 'nullable|json',
            'prices' => 'nullable|json',
            'quantities' => 'nullable|json',
        ]);




        // If names/prices/quantities are not set, fallback to single quantity
    $names = $validated['names'] ?? null;
    $prices = $validated['prices'] ?? null;
    $quantities = $validated['quantities'] ?? null;

    // Fallback for single item
    if (!$names && !$prices && !$quantities && $request->has('quantity')) {
        $names = json_encode([$request->input('patient_name')]);
        $prices = json_encode([0]);
        $quantities = json_encode([$request->input('quantity')]);
    }
        
        $invoice = Invoice::create([
            'pid' => 'INV-' . uniqid(), // Generate a unique invoice ID
            'name' => $validated['names'],
            'price' => $validated['prices'],
            'qty' => $validated['quantities'],
            'discount' => $validated['discount'] ?? 0,
        ]);
        
        return redirect()->back()->with('success', 'Invoice created successfully!');
    }
    public function index(){
        return view('doctors.invoice');
    }

    public function newIndex(){
        return view('invoice.newinvoice');
    }
    public function show(Request $request){
        // ?patient= (from the patient chart) or the value typed before a failed save.
        $pid = trim((string) old('pid', $request->query('patient', '')));
        $patient = $pid !== '' ? PatientInfo::where('patient_id', $pid)->first() : null;

        return view('inventory.generateinvoice', compact('pid', 'patient'));
    }


  public function save(Request $request){
    // Drop rows left completely empty (e.g. "Add" clicked once too often) so they don't block the invoice.
    $request->merge([
        'inputs' => array_values(array_filter((array) $request->input('inputs', []), function ($row) {
            return is_array($row) && collect($row)->contains(fn ($value) => filled($value));
        })),
    ]);

    // Validate the request
                $validatedData = $request->validate([
                    'inputs' => 'required|array',
                    'discount' => 'required|integer|between:0,100',
                    'inputs.*.name' => 'required|string',
                    'inputs.*.price' => 'required|numeric',
                    'inputs.*.qty' => 'required|integer',
                ], [
                    'inputs.required' => 'Add at least one item to the invoice.',
                    'discount.between' => 'Discount is a percentage and must be between 0 and 100.',
                    'discount.integer' => 'Discount must be a whole-number percentage, e.g. 10.',
                    'inputs.*.name.required' => 'Row :position: item name is required.',
                    'inputs.*.price.required' => 'Row :position: price is required. Pick the item from the list so its price fills in.',
                    'inputs.*.price.numeric' => 'Row :position: price must be a number (no commas or currency signs).',
                    'inputs.*.qty.required' => 'Row :position: quantity is required.',
                    'inputs.*.qty.integer' => 'Row :position: quantity must be a whole number.',
                ]);
    
    // Calculate subtotal
    $subtotal = 0;
    foreach ($request->input('inputs') as $input) {
        $subtotal += $input['price'] * $input['qty'];
    }

    // Apply discount
    $discountPercentage = $request->input('discount');
    $discountAmount = $subtotal * ($discountPercentage / 100);
    $total = $subtotal - $discountAmount;


    // Create and save the invoice
    $invoice = new Invo();
        $invoice->discount = $request->input('discount');
        $invoice->pid = $request->input('pid');
        $invoice->name = $request->input('inputs.*.name');
        $invoice->price = $request->input('inputs.*.price');
        $invoice->qty = $request->input('inputs.*.qty');
        $invoice->amount = $total; // Save the total amount after discount
    $invoice->save();

    // Process each input
    foreach ($request->input('inputs') as $input) {
        $name = $input['name'];
        $price = $input['price'];
        $qty = $input['qty'];

        // Save each item detail in the invoice (assuming an InvoiceItem model)
        // $invoiceItem = new Invo();
        // $invoiceItem->invoice_id = $invoice->id;
        // $invoiceItem->name = $name;
        // $invoiceItem->price = $price;
        // $invoiceItem->qty = $qty;
        // $invoiceItem->save();

        // Update the quantities in Drugs, Lenses, and Frames models
        // Remove the (Drug), (Lens), or (Frame) suffix if present
        $cleanName = preg_replace('/\s*\((Drug|Lens|Frame)\)$/', '', $name);

        // Low stock never blocks an invoice. Stock may go below zero, which shows how much was sold beyond what was recorded.
        $drug = Drug::where('name', $cleanName)->first();
        if ($drug) {
            $drug->quantity -= $qty;
            $drug->save();
            continue;
        }

        $lens = Lens::where('name', $cleanName)->first();
        if ($lens) {
            $lens->quantity -= $qty;
            $lens->save();
            continue;
        }

        $frame = Frame::where('name', $cleanName)->first();
        if ($frame) {
            $frame->quantity -= $qty;
            $frame->save();
            continue;
        }
    }

    // Open the receipt for this invoice, not just whichever invoice is newest.
    return redirect(route('invoice.show', ['id' => $invoice->id]));
}
    
//     public function save(Request $request){
//     // Validate the request
//     $validatedData = $request->validate([
//         'inputs' => 'required|array',
//         'discount' => 'required',
//         'inputs.*.name' => 'required|string',
//         'inputs.*.price' => 'required|numeric',
//         'inputs.*.qty' => 'required|integer',
//     ]);

//     // Create and save the invoice
//     $invoice = new Invo();
//         $invoice->discount = $request->input('discount');
//         $invoice->pid = $request->input('pid');
//         $invoice->name = $request->input('inputs.*.name');
//         $invoice->price = $request->input('inputs.*.price');
//         $invoice->qty = $request->input('inputs.*.qty');
//     $invoice->save();

//     // Process each input
//     foreach ($request->input('inputs') as $input) {
//         $name = $input['name'];
//         $price = $input['price'];
//         $qty = $input['qty'];

//         // Save each item detail in the invoice (assuming an InvoiceItem model)
//         // $invoiceItem = new Invo();
//         // $invoiceItem->invoice_id = $invoice->id;
//         // $invoiceItem->name = $name;
//         // $invoiceItem->price = $price;
//         // $invoiceItem->qty = $qty;
//         // $invoiceItem->save();

//         // Update the quantities in Drugs, Lenses, and Frames models
//         $drug = Drug::where('name', $name)->first();
//         if ($drug) {
//             if ($drug->quantity - $qty < 1) {
//                 return redirect(route('pages.status'))->with('success', 'Insufficient Drug Stock');
//             }
//             $drug->quantity -= $qty;
//             $drug->save();
//             continue;
//         }

//         $lens = Lens::where('name', $name)->first();
//         if ($lens) {
//             if ($lens->quantity - $qty < 1) {
//                 return redirect(route('pages.status'))->with('success', 'Insufficient Lens Stock');
//             }
//             $lens->quantity -= $qty;
//             $lens->save();
//             continue;
//         }

//         $frame = Frame::where('name', $name)->first();
//         if ($frame) {
//             if ($frame->quantity - $qty < 1) {
//                 return redirect(route('pages.status'))->with('success', 'Insufficient Frame Stock');
//             }
//             $frame->quantity -= $qty;
//             $frame->save();
//             continue;
//         }
//     }

//     return redirect('/invoice');
// }

    /**
     * Find invoice: one searchable, paged list (/invoice/find and the old /invoice/search?query=).
     * The search matches a receipt number (RCT-000042 or 42), what was typed as the patient (walk-in names,
     * Patient IDs) and registered patients' names, so an invoice made by picking a patient is found by name too.
     */
    public function find(Request $request){
        $query = trim((string) $request->query('query', ''));
        $range = $this->invoiceRange($request);

        $filtered = Invo::query()
            ->when($query !== '', function ($q) use ($query) {
                $patientIds = PatientInfo::query()->matching($query)->limit(200)->pluck('patient_id');
                $receiptId = preg_match('/^(?:RCT-?)?0*(\d+)$/i', $query, $m) ? (int) $m[1] : null;

                $q->where(function ($w) use ($query, $patientIds, $receiptId) {
                    $w->where('pid', 'LIKE', "%{$query}%")
                        ->when($patientIds->isNotEmpty(), fn ($x) => $x->orWhereIn('pid', $patientIds))
                        ->when($receiptId, fn ($x) => $x->orWhere('id', $receiptId));
                });
            })
            ->when($range['from'], fn ($q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($range['to'], fn ($q, $to) => $q->whereDate('created_at', '<=', $to));

        // Summary for everything matching (not just this page), with the same maths as the receipts and reports.
        $all = (clone $filtered)->get(['id', 'name', 'price', 'qty', 'discount']);
        $summary = [
            'count' => $all->count(),
            'net' => $all->sum(fn (Invo $i) => $i->totals()['net']),
            'discount' => $all->sum(fn (Invo $i) => $i->totals()['discount']),
        ];

        $invoices = $filtered->orderByDesc('created_at')->orderByDesc('id')->paginate(25)->withQueryString();

        // Registered patients on this page, so rows show a name and link to the chart.
        $patients = PatientInfo::whereIn('patient_id', $invoices->pluck('pid')->filter()->unique())
            ->get()->keyBy('patient_id');

        return view('invoice.find', compact('invoices', 'patients', 'summary', 'query', 'range'));
    }

    public function search(Request $request){
        return $this->find($request);
    }

    /** Date filter: a preset (today, week, month) or a from/to pair of Y-m-d dates. */
    private function invoiceRange(Request $request): array
    {
        $date = fn ($v) => is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v) ? $v : null;

        return match ($request->query('period')) {
            'today' => ['period' => 'today', 'from' => today()->toDateString(), 'to' => today()->toDateString()],
            'week' => ['period' => 'week', 'from' => today()->subDays(6)->toDateString(), 'to' => today()->toDateString()],
            'month' => ['period' => 'month', 'from' => today()->startOfMonth()->toDateString(), 'to' => today()->toDateString()],
            default => ['period' => null, 'from' => $date($request->query('from')), 'to' => $date($request->query('to'))],
        };
    }



    //  public function getAllInvoices()
    // {
    //     $invoices = Invo::all();

    //     $processedInvoices = $invoices->map(function ($invoice) {
    //         // Decode JSON fields
    //         $names = json_decode($invoice->name, true);
    //         $prices = json_decode($invoice->price, true);
    //         $qtys = json_decode($invoice->qty, true);
    //         $discount = $invoice->discount ?? 0;

    //         // Calculate total for this invoice = sum of price * qty for each item
    //         $totalBeforeDiscount = 0;
    //         for ($i = 0; $i < count($names); $i++) {
    //             $totalBeforeDiscount += ($prices[$i] ?? 0) * ($qtys[$i] ?? 0);
    //         }

    //         $totalAfterDiscount = max($totalBeforeDiscount - $discount, 0);

    //         return [
    //             'id' => $invoice->id,
    //             'pid' => $invoice->pid,
    //             'items' => array_map(function ($name, $price, $qty) {
    //                 return [
    //                     'name' => $name,
    //                     'price' => $price,
    //                     'qty' => $qty,
    //                     'subtotal' => $price * $qty,
    //                 ];
    //             }, $names, $prices, $qtys),
    //             'discount' => $discount,
    //             'total_before_discount' => $totalBeforeDiscount,
    //             'total_after_discount' => $totalAfterDiscount,
    //             'created_at' => $invoice->created_at,
    //             'updated_at' => $invoice->updated_at,
    //         ];
    //     });

    //     // You can also calculate overall total revenue here if needed:
    //     $totalRevenue = $processedInvoices->sum('total_after_discount');

    //     return response()->json([
    //         'total_revenue' => $totalRevenue,
    //         'count' => $processedInvoices->count(),
    //         'invoices' => $processedInvoices,
    //     ]);
    // }


    public function getAllInvoices()
{
    $threeMonthsAgo = now()->subMonths(3);

    // Get invoices from the last 3 months only
    $invoices = Invo::where('created_at', '>=', $threeMonthsAgo)->get();

    $processedInvoices = $invoices->map(function ($invoice) {
        // Discount is a percentage of the subtotal; totals() applies it the same way save() does.
        $totals = $invoice->totals();

        return [
            'id' => $invoice->id,
            'pid' => $invoice->pid,
            'items' => $invoice->lines(),
            'discount' => $invoice->discountPercent(),
            'discount_amount' => $totals['discount'],
            'total_before_discount' => $totals['gross'],
            'total_after_discount' => $totals['net'],
            'created_at' => $invoice->created_at,
            'updated_at' => $invoice->updated_at,
        ];
    });

    // Calculate overall total revenue for last 3 months
    $totalRevenue = $processedInvoices->sum('total_after_discount');

    return response()->json([
        'total_revenue' => $totalRevenue,
        'count' => $processedInvoices->count(),
        'invoices' => $processedInvoices,
    ]);
}

}
