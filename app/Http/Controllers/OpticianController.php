<?php

namespace App\Http\Controllers;

use App\Models\Opticians;
use App\Models\Appointment;
use App\Models\Notification;
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
            'patients.*.posted_from' => 'nullable|string|max:100',
            'patients.*.card_number' => 'nullable|string|max:50',
            'patients.*.frame_type' => 'nullable|string|max:50',
            'patients.*.qty' => 'nullable|integer',
        ]);

        foreach ($request->patients as $patientData) {
            Opticians::create([
                'date' => $patientData['date'],
                'patient_name' => $patientData['patient_name'],
                'power' => $patientData['power'],
                'posted_from' => $patientData['posted_from'],
                'card_number' => $patientData['card_number'],
                'frame_type' => $patientData['frame_type'],
                'qty' => $patientData['qty'],
            ]);
        }

        return back()->with('success', 'Patient records saved successfully!');
    }


    public function list(){
        $opticians = Opticians::all();
        return view('optician.list', compact('opticians'));
    }

    public function find(){
        return view('optician.find');
    }

    public function search(){
        $search_text = (string) request()->query('query', '');
        $treatments = Opticians::where('card_number', $search_text)
        ->get();        
         return view('optician.listsearch', ['treatments' => $treatments]);
    }

}
