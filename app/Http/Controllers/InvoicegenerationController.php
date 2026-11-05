<?php
namespace App\Http\Controllers;

use App\Models\Invo;
use App\Models\PatientInfo;
use Illuminate\Http\Request;

class InvoicegenerationController extends Controller
{
    // Receipt for one invoice (?id=...). Without an id it falls back to the latest invoice, as before.
    public function index(Request $request){
        $invoice = $request->filled('id')
            ? Invo::findOrFail($request->integer('id'))
            : Invo::latest('id')->first();

        if (! $invoice) {
            return redirect(route('generate.show'))->with('info', 'No invoices yet. Create one below.');
        }

        $patient = PatientInfo::where('patient_id', $invoice->pid)->first();

        return view('invoice.invoiceTwo', compact('invoice', 'patient'));
    }
}
