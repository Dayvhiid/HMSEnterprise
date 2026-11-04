<?php

namespace App\Http\Controllers;

use App\Models\Invo;
use App\Models\Test;
use App\Models\Drug;
use App\Models\Lens;
use App\Models\Frame;
use App\Models\Invoice;
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
    public function show(){
        return view('inventory.generateinvoice');
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
                    'discount' => 'required',
                    'inputs.*.name' => 'required|string',
                    'inputs.*.price' => 'required|numeric',
                    'inputs.*.qty' => 'required|integer',
                ], [
                    'inputs.required' => 'Add at least one item to the invoice.',
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

    return redirect('/invoice');
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

    public function find(){
        return view('invoice.search');
    }
    public function search(){
        $search_text = $_GET['query'];
        $users = Invo::where(function ($query) use ($search_text) {
            $query->where('pid', 'LIKE', "%{$search_text}%");})
        ->get();
        return view('invoice.invoicesearch', compact('users'));
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
        // Decode JSON fields
        $names = json_decode($invoice->name, true);
        $prices = json_decode($invoice->price, true);
        $qtys = json_decode($invoice->qty, true);
        $discount = $invoice->discount ?? 0;

        // Calculate total for this invoice = sum of price * qty for each item
        $totalBeforeDiscount = 0;
        for ($i = 0; $i < count($names); $i++) {
            $totalBeforeDiscount += ($prices[$i] ?? 0) * ($qtys[$i] ?? 0);
        }

        $totalAfterDiscount = max($totalBeforeDiscount - $discount, 0);

        return [
            'id' => $invoice->id,
            'pid' => $invoice->pid,
            'items' => array_map(function ($name, $price, $qty) {
                return [
                    'name' => $name,
                    'price' => $price,
                    'qty' => $qty,
                    'subtotal' => $price * $qty,
                ];
            }, $names, $prices, $qtys),
            'discount' => $discount,
            'total_before_discount' => $totalBeforeDiscount,
            'total_after_discount' => $totalAfterDiscount,
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
