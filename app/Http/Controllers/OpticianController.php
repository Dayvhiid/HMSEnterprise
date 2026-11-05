<?php

namespace App\Http\Controllers;

use App\Models\Opticians;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\PatientInfo;
use Illuminate\Http\Request;

class OpticianController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display a list of opticians
         $appointments = Appointment::latest()->limit(5)->get();
        $notifications = Notification::latest()->limit(7)->get();
        return view('optician.index', compact('appointments', 'notifications'));
    }


    public function records(){
          return view('optician.records');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'patients.*.date' => 'required|date',
            'patients.*.patient_name' => 'required|string|max:100',
            'patients.*.power' => 'nullable|string|max:50',
            'patients.*.patient_id' => 'nullable|string|max:50|exists:patient_infos,patient_id',
            'patients.*.frame_type' => 'nullable|string|max:50',
            'patients.*.qty' => 'nullable|integer',
        ], [
            'patients.*.patient_id.exists' => 'No registered patient has the ID ":input".',
        ]);

        // The clinic Patient ID is kept in the card_number column (no schema change). "Posted from" is no
        // longer collected; the column stays for older records.
        foreach ($request->patients as $patientData) {
            Opticians::create([
                'date' => $patientData['date'],
                'patient_name' => $patientData['patient_name'],
                'power' => $patientData['power'] ?? null,
                'card_number' => $patientData['patient_id'] ?? null,
                'frame_type' => $patientData['frame_type'] ?? null,
                'qty' => $patientData['qty'] ?? null,
            ]);
        }

        return back()->with('success', 'Patient records saved successfully!');
    }


    /**
     * Dispensing records: one searchable, paged list. /optician/list, /optician/find and
     * /optician/search?query= all show it, so old links and bookmarks keep working.
     * The search finds a card number or part of a patient name.
     */
    public function list(Request $request)
    {
        $query = trim((string) $request->query('query', ''));

        $records = Opticians::query()
            ->when($query !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('card_number', 'LIKE', "%{$query}%")
                ->orWhere('patient_name', 'LIKE', "%{$query}%")))
            ->orderByDesc('date')->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        // Patient IDs on this page that belong to a registered patient => their chart id, for linking.
        $chartIds = PatientInfo::whereIn('patient_id', $records->pluck('card_number')->filter()->unique())
            ->pluck('id', 'patient_id');

        return view('optician.list', ['records' => $records, 'query' => $query, 'chartIds' => $chartIds]);
    }

    public function find(Request $request)
    {
        return $this->list($request);
    }

    public function search(Request $request)
    {
        return $this->list($request);
    }
}
