<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Drug;
use App\Models\Invo;
use App\Models\Lens;
use App\Models\Test;
 use App\Models\PatientInfo;
use App\Models\Event;
// use Illuminate\Support\Carbon;
use App\Models\Frame;
use App\Models\Inventory;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AdminController extends Controller
{
    public function index(){
        return view('admin.admin2.admin2');
    }
      public function indexTwo(){
        return view('admin.admin2.newadmin2');
    }
    public function drugsIndex(){
        return view('admin.admin2.admin2drugs');
    }
    public function drugsIndexTwo(){
        return view('admin.admin2.admin2drugsIndex');
    }
    public function inventoryIndex(){
        $item = Inventory::paginate(9);
        return view ('admin.admin2.admin2inventory', ['item' => $item]);
    }
    public function drugList(){
        $drugs = Drug::paginate(9);
        return view('admin.admin2.admin2druglist', ['drugs' => $drugs]);
    }
    public function frameIndex(){
        return view('admin.admin2.admin2frame');
    }
      public function frameIndexTwo(){
        return view('admin.admin2.newadmin2frame');
    }
    public function frameList(){
        $frames = Frame::paginate(9);
        return view('admin.admin2.admin2framelist', [ 'frames' => $frames]);
    }
    public function lensIndex(){
        return view('admin.admin2.admin2lens');
    }
     public function lensIndexTwo(){
        return view('admin.admin2.newadmin2lens');
    }
    public function lensList(){
        $lens = Lens::paginate(9);
        return view('admin.admin2.admin2lenslist', [ 'lens' => $lens]);
    }
     public function dashboard(){

      $now = Carbon::now();
        
        // Get count of all upcoming events
        $upcomingEventsCount = Event::where('end', '>', $now)->count();
        
        // Get the closest upcoming event
        $nextEvent = Event::where('start', '>', $now)
                          ->orderBy('start', 'asc')
                          ->first();

        $appointment_count = Appointment::count();
        $appointments = Appointment::latest()->take(10)->get();
        return view('admin.dashboard',  [ 'appointment_count' => $appointment_count, 
                                           'appointments' => $appointments,
                                           'upcomingEventsCount' => $upcomingEventsCount,
                                             'nextEvent' => $nextEvent->title ?? 'No upcoming events',
                                        ]);
    }

    // public function demographics(){
    //     return view('admin.demographics');
    // }

   

public function demographics() {
    // Get counts for each age group and gender
    $ageGroups = [
        '0-18' => [
            'male' => PatientInfo::where('gender', 'male')
                        ->whereBetween('age', [0, 18])
                        ->count(),
            'female' => PatientInfo::where('gender', 'female')
                          ->whereBetween('age', [0, 18])
                          ->count(),
        ],
        '19-35' => [
            'male' => PatientInfo::where('gender', 'male')
                        ->whereBetween('age', [19, 35])
                        ->count(),
            'female' => PatientInfo::where('gender', 'female')
                          ->whereBetween('age', [19, 35])
                          ->count(),
        ],
        '36-55' => [
            'male' => PatientInfo::where('gender', 'male')
                        ->whereBetween('age', [36, 55])
                        ->count(),
            'female' => PatientInfo::where('gender', 'female')
                          ->whereBetween('age', [36, 55])
                          ->count(),
        ],
        '56-75' => [
            'male' => PatientInfo::where('gender', 'male')
                        ->whereBetween('age', [56, 75])
                        ->count(),
            'female' => PatientInfo::where('gender', 'female')
                          ->whereBetween('age', [56, 75])
                          ->count(),
        ],
        '75+' => [
            'male' => PatientInfo::where('gender', 'male')
                        ->where('age', '>', 75)
                        ->count(),
            'female' => PatientInfo::where('gender', 'female')
                          ->where('age', '>', 75)
                          ->count(),
        ],
    ];

    // Calculate totals
    $totals = [
        'male' => PatientInfo::where('gender', 'male')->count(),
        'female' => PatientInfo::where('gender', 'female')->count(),
        'all' => PatientInfo::count()
    ];

    return view('admin.demographics', compact('ageGroups', 'totals'));
}

public function staff(){
    return view('admin.staff', [
        'users' => User::orderBy('name')->get(),
        'roles' => User::ROLE_LABELS,
    ]);
}

// Public sign-up is disabled, so administrators create staff accounts here.
public function storeStaff(Request $request){
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
        'role' => ['required', Rule::in(array_keys(User::ROLE_LABELS))],
        'password' => ['required', 'confirmed', Password::defaults()],
    ], [
        'email.unique' => 'A staff member already uses that email address.',
    ]);

    $user = new User();
    $user->forceFill([
        'name' => $data['name'],
        'email' => $data['email'],
        'role' => $data['role'],
        'password' => Hash::make($data['password']),
        'email_verified_at' => now(),
    ])->save();

    return redirect(route('admin.staff'))->with('success', $user->name.' was added as '.$user->roleLabel().'.');
}


public function inventoryAnalytics(){
    $threshold = max((int) request('threshold', 10), 1);

    $totalDrugs = Drug::count();
    $totalFrames = Frame::count();
    $totalLenses = Lens::count();
    $total = $totalDrugs + $totalFrames + $totalLenses;

    $valueDrugs = (float) Drug::sum(DB::raw('price * quantity'));
    $valueFrames = (float) Frame::sum(DB::raw('price * quantity'));
    $valueLenses = (float) Lens::sum(DB::raw('price * quantity'));
    $totalValue = $valueDrugs + $valueFrames + $valueLenses;

    $toLowStockPayload = function ($items, string $type) use ($threshold) {
        return $items->map(function ($item) use ($type, $threshold) {
            $quantity = (int) ($item->quantity ?? 0);
            $price = (float) ($item->price ?? 0);
            $criticalCutoff = (int) ceil($threshold / 2);
            $severity = $quantity <= $criticalCutoff ? 'critical' : 'warning';
            $reorderQty = max($threshold - $quantity, 0);

            return [
                'type' => $type,
                'sn' => $item->sn,
                'name' => $item->name,
                'special_code' => $item->special_code,
                'quantity' => $quantity,
                'price' => $price,
                'value' => $quantity * $price,
                'reorder_qty' => $reorderQty,
                'severity' => $severity,
            ];
        });
    };

    $lowStockDrugsItems = Drug::where('quantity', '<', $threshold)
        ->select('sn', 'name', 'special_code', 'quantity', 'price')
        ->get();
    $lowStockFramesItems = Frame::where('quantity', '<', $threshold)
        ->select('sn', 'name', 'special_code', 'quantity', 'price')
        ->get();
    $lowStockLensesItems = Lens::where('quantity', '<', $threshold)
        ->select('sn', 'name', 'special_code', 'quantity', 'price')
        ->get();

    $lowStockDrugs = $lowStockDrugsItems->count();
    $lowStockFrames = $lowStockFramesItems->count();
    $lowStockLenses = $lowStockLensesItems->count();
    $lowStockTotal = $lowStockDrugs + $lowStockFrames + $lowStockLenses;

    $lowStockItems = collect()
        ->merge($toLowStockPayload($lowStockDrugsItems, 'Drug'))
        ->merge($toLowStockPayload($lowStockFramesItems, 'Frame'))
        ->merge($toLowStockPayload($lowStockLensesItems, 'Lens'))
        ->sortBy('quantity')
        ->values();

    $startDate = Carbon::now()->subDays(29)->startOfDay();
    $endDate = Carbon::now()->endOfDay();

    $movements = Inventory::whereDate('date', '>=', $startDate->toDateString())
        ->whereDate('date', '<=', $endDate->toDateString())
        ->get(['date', 'name', 'patient_code', 'booklet_no', 'qty_in', 'qty_out', 'balance', 'new_stock']);

    $totalInbound = 0;
    $totalOutbound = 0;
    $restockEntries = 0;

    $dailyMovementMap = [];
    for ($i = 29; $i >= 0; $i--) {
        $dateKey = Carbon::now()->subDays($i)->toDateString();
        $dailyMovementMap[$dateKey] = [
            'in' => 0,
            'out' => 0,
        ];
    }

    foreach ($movements as $movement) {
        $dateKey = Carbon::parse($movement->date)->toDateString();
        $inQty = (int) ($movement->qty_in ?? 0);
        $outQty = (int) ($movement->qty_out ?? 0);

        $totalInbound += $inQty;
        $totalOutbound += $outQty;

        if ((int) ($movement->new_stock ?? 0) > 0) {
            $restockEntries++;
        }

        if (array_key_exists($dateKey, $dailyMovementMap)) {
            $dailyMovementMap[$dateKey]['in'] += $inQty;
            $dailyMovementMap[$dateKey]['out'] += $outQty;
        }
    }

    $dateLabels = [];
    $netMovementData = [];
    $inboundData = [];
    $outboundData = [];
    foreach ($dailyMovementMap as $dateKey => $movementData) {
        $dateLabels[] = Carbon::parse($dateKey)->format('M d');
        $inboundData[] = $movementData['in'];
        $outboundData[] = $movementData['out'];
        $netMovementData[] = $movementData['in'] - $movementData['out'];
    }

    $recentMovements = Inventory::orderByDesc('date')
        ->limit(8)
        ->get(['date', 'name', 'patient_code', 'booklet_no', 'qty_in', 'qty_out', 'balance'])
        ->map(function ($row) {
            return [
                'date' => Carbon::parse($row->date)->format('Y-m-d'),
                'name' => $row->name,
                'patient_code' => $row->patient_code,
                'booklet_no' => $row->booklet_no,
                'qty_in' => (int) ($row->qty_in ?? 0),
                'qty_out' => (int) ($row->qty_out ?? 0),
                'balance' => (int) ($row->balance ?? 0),
            ];
        })->values();

    $topConsumed = [];
    $recentInvoices = Invo::where('created_at', '>=', $startDate)->get(['name', 'qty']);
    foreach ($recentInvoices as $invoice) {
        $names = is_array($invoice->name) ? $invoice->name : json_decode((string) $invoice->name, true);
        $qtys = is_array($invoice->qty) ? $invoice->qty : json_decode((string) $invoice->qty, true);

        if (!is_array($names) || !is_array($qtys)) {
            $names = array_filter(array_map('trim', explode(',', (string) $invoice->name)));
            $qtys = array_filter(array_map('trim', explode(',', (string) $invoice->qty)));
        }

        foreach ($names as $idx => $itemName) {
            $qty = (int) ($qtys[$idx] ?? 0);
            if ($qty < 1) {
                continue;
            }
            if (!isset($topConsumed[$itemName])) {
                $topConsumed[$itemName] = 0;
            }
            $topConsumed[$itemName] += $qty;
        }
    }

    arsort($topConsumed);
    $topConsumedRows = collect(array_slice($topConsumed, 0, 7, true))
        ->map(function ($qty, $name) {
            return [
                'name' => $name,
                'qty' => (int) $qty,
            ];
        })->values();

    return view('admin.inventoryanalytics',[
        'summary' => [
            'totals' => [
                'drugs' => $totalDrugs,
                'frames' => $totalFrames,
                'lenses' => $totalLenses,
                'total' => $total,
            ],
            'values' => [
                'drugs' => $valueDrugs,
                'frames' => $valueFrames,
                'lenses' => $valueLenses,
                'total' => $totalValue,
            ],
            'lowStock' => [
                'drugs' => $lowStockDrugs,
                'frames' => $lowStockFrames,
                'lenses' => $lowStockLenses,
                'total' => $lowStockTotal,
            ],
        ],
        'kpis' => [
            'inbound_units' => $totalInbound,
            'outbound_units' => $totalOutbound,
            'net_units' => $totalInbound - $totalOutbound,
            'restock_entries' => $restockEntries,
            'critical_low_stock' => $lowStockItems->where('severity', 'critical')->count(),
        ],
        'threshold' => $threshold,
        'chart' => [
            'labels' => $dateLabels,
            'net' => $netMovementData,
            'inbound' => $inboundData,
            'outbound' => $outboundData,
        ],
        'lowStockItems' => $lowStockItems,
        'topConsumedRows' => $topConsumedRows,
        'recentMovements' => $recentMovements,
    ]);
}


public function inventoryTwoAnalytics(){
    return view('admin.inventorytwoanalytics');
}


// public function invoiceAnalytics()
// {
//     return view('admin.invoiceanalytics');
// }



// use Illuminate\Support\Facades\DB;





// public function invoiceAnalytics()
// {
//     // Date 3 months ago
//     $threeMonthsAgo = Carbon::now()->subMonths(3)->startOfDay();

//     // Fetch invoices from the last 3 months
//     $invoices = Invo::where('created_at', '>=', $threeMonthsAgo)->get();

//     // Initialize variables
//     $totalRevenue = 0;
//     $totalProductsSold = 0;
//     $discountImpact = 0;
//     $productStats = [];

//     foreach ($invoices as $invoice) {
//         $names = $invoice->name;
//         $prices = $invoice->price;
//         $quantities = $invoice->qty;
//         $discount = $invoice->discount ?? 0;

//         $discountImpact += $discount;

//         // foreach ( $names as $index => $productName ) {
//         //     $quantity = $quantities[$index];
//         //     $price = $prices[$index];
//         //     $lineTotal = $quantity * $price;

//         //     // Accumulate revenue
//         //     $totalRevenue += $lineTotal;

//         //     // Accumulate product stats
//         //     if (!isset($productStats[$productName])) {
//         //         $productStats[$productName] = [
//         //             'quantity' => 0,
//         //             'revenue' => 0,
//         //         ];
//         //     }

//         //     $productStats[$productName]['quantity'] += $quantity;
//         //     $productStats[$productName]['revenue'] += $lineTotal;

//         //     // Accumulate total products sold
//         //     $totalProductsSold += $quantity;
//         // }


//       if (is_string($names)) {
//     $names = explode(',', $names);
// }
// if (is_string($quantities)) {
//     $quantities = explode(',', $quantities);
// }
// if (is_string($prices)) {
//     $prices = explode(',', $prices);
// }


//         foreach ($names as $index => $productName) {
//                 $quantity = $quantities[$index] ?? 0; // Prevent index errors
//                 $price = $prices[$index] ?? 0;

//     $lineTotal = $quantity * $price;

//     // Accumulate revenue
//     $totalRevenue += $lineTotal;

//     // Accumulate product stats
//     if (!isset($productStats[$productName])) {
//         $productStats[$productName] = [
//             'quantity' => 0,
//             'revenue' => 0,
//         ];
//     }

//     $productStats[$productName]['quantity'] += $quantity;
//     $productStats[$productName]['revenue'] += $lineTotal;

//     // Accumulate total products sold
//     $totalProductsSold += $quantity;
// }

//     }

//     // Count of total invoices
//     $totalInvoices = $invoices->count();

//     // Average invoice value
//     $averageInvoiceValue = $totalInvoices > 0 ? round($totalRevenue / $totalInvoices, 2) : 0;

//     // Convert stats array to collection
//     $productStatsCollection = collect($productStats);

//     // Top 5 products by quantity
//     $topProductsByQuantity = $productStatsCollection->sortByDesc('quantity')->take(5)->map(function ($item, $productName) use ($totalProductsSold) {
//         return [
//             'product_name' => $productName,
//             'total_quantity' => $item['quantity'],
//             'percentage' => $totalProductsSold > 0 ? round(($item['quantity'] / $totalProductsSold) * 100, 2) : 0,
//         ];
//     });

//     // Top 5 products by revenue
//     $topProductsByRevenue = $productStatsCollection->sortByDesc('revenue')->take(5)->map(function ($item, $productName) use ($totalRevenue) {
//         return [
//             'product_name' => $productName,
//             'product_revenue' => $item['revenue'],
//             'percentage' => $totalRevenue > 0 ? round(($item['revenue'] / $totalRevenue) * 100, 2) : 0,
//         ];
//     });


    

//     return view('admin.invoiceanalytics', [
//         'totalRevenue' => $totalRevenue,
//         'averageInvoiceValue' => $averageInvoiceValue,
//         'totalInvoices' => $totalInvoices,
//         'totalProductsSold' => $totalProductsSold,
//         'discountImpact' => $discountImpact,
//         'topProductsByQuantity' => $topProductsByQuantity,
//         'topProductsByRevenue' => $topProductsByRevenue,
//     ]);
// }

public function invoiceAnalytics()
{
    $threeMonthsAgo = Carbon::now()->subMonths(3)->startOfDay();
    $invoices = Invo::where('created_at', '>=', $threeMonthsAgo)->get();

    $totalRevenue = 0;
    $totalProductsSold = 0;
    $discountImpact = 0;
    $productStats = [];

    $dailyData = []; // For charting

    $grossSales = 0;

    foreach ($invoices as $invoice) {
        // Revenue is what patients actually pay: line totals minus the invoice's percentage discount.
        $totals = $invoice->totals();
        $discountImpact += $totals['discount'];
        $grossSales += $totals['gross'];
        $netShare = 1 - $invoice->discountPercent() / 100;

        $invoiceDate = $invoice->created_at->format('Y-m-d');

        $dailyQty = 0;
        $dailyRevenue = 0;

        foreach ($invoice->lines() as $line) {
            $productName = $line['name'];
            $quantity = $line['qty'];
            // Each line carries its share of the invoice discount, so product revenue adds up to net revenue.
            $lineTotal = $line['subtotal'] * $netShare;

            // Track daily data
            $dailyQty += $quantity;
            $dailyRevenue += $lineTotal;

            $totalRevenue += $lineTotal;
            $totalProductsSold += $quantity;

            if (!isset($productStats[$productName])) {
                $productStats[$productName] = ['quantity' => 0, 'revenue' => 0];
            }

            $productStats[$productName]['quantity'] += $quantity;
            $productStats[$productName]['revenue'] += $lineTotal;
        }

        // Aggregate daily totals
        if (!isset($dailyData[$invoiceDate])) {
            $dailyData[$invoiceDate] = ['quantity' => 0, 'revenue' => 0];
        }

        $dailyData[$invoiceDate]['quantity'] += $dailyQty;
        $dailyData[$invoiceDate]['revenue'] += $dailyRevenue;
    }

    // Prepare for charts
    ksort($dailyData); // Sort by date

    $dates = array_keys($dailyData);
    $dailyQuantities = array_column($dailyData, 'quantity');
    $dailyRevenues = array_column($dailyData, 'revenue');

    $totalInvoices = $invoices->count();
    $averageInvoiceValue = $totalInvoices > 0 ? round($totalRevenue / $totalInvoices, 2) : 0;

    $productStatsCollection = collect($productStats);

    $topProductsByQuantity = $productStatsCollection->sortByDesc('quantity')->take(5)->map(function ($item, $productName) use ($totalProductsSold) {
        return [
            'product_name' => $productName,
            'total_quantity' => $item['quantity'],
            'percentage' => $totalProductsSold > 0 ? round(($item['quantity'] / $totalProductsSold) * 100, 2) : 0,
        ];
    });

    $topProductsByRevenue = $productStatsCollection->sortByDesc('revenue')->take(5)->map(function ($item, $productName) use ($totalRevenue) {
        return [
            'product_name' => $productName,
            'product_revenue' => $item['revenue'],
            'percentage' => $totalRevenue > 0 ? round(($item['revenue'] / $totalRevenue) * 100, 2) : 0,
        ];
    });

    return view('admin.invoiceanalytics', [
        'totalRevenue' => $totalRevenue,
        'grossSales' => $grossSales,
        'averageInvoiceValue' => $averageInvoiceValue,
        'totalInvoices' => $totalInvoices,
        'totalProductsSold' => $totalProductsSold,
        'discountImpact' => $discountImpact,
        'topProductsByQuantity' => $topProductsByQuantity,
        'topProductsByRevenue' => $topProductsByRevenue,
        'dates' => $dates,
        'dailyQuantities' => $dailyQuantities,
        'dailyRevenues' => $dailyRevenues,
    ]);
}






    



}
