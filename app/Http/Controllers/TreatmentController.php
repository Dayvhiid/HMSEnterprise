<?php

namespace App\Http\Controllers;

use App\Models\Treat;

use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index(){
        // return view('doctors.treatment');
        return view('doctors.newIndex');
    }
    public function index2(){
        return view('doctors.treatment2');
    }
    public function store(Request $request) {
        $validatedData = $request->validate([
            'singlevision' => 'array',
            'bifocal' => 'array',
            'specialorder' => 'array',
            'progressive' => 'array',
            'patient_id' => 'required|string|exists:patient_infos,patient_id',
            // 'dosage' => 'required',
            // 'duration' => 'required',
            // 'tab' => 'required',
            // 'gutt' => 'required',
            // 'oc' => 'required',
            // 'sur' => 'required',
            // 'rtc' => 'required',
            // 'remark' => 'required',
        ], [
            'patient_id.required' => 'Enter the Patient ID before saving.',
            'patient_id.exists' => 'No patient has that Patient ID. Check the ID on the patient card.',
        ]);
    
        $treatment = new Treat;
        $treatment->patient_id = $request->input('patient_id');
        $treatment->dosage = $request->input('dosage');
        $treatment->duration = (string) $request->input('duration', '');
        $treatment->tab = $request->input('tab');
        $treatment->gutt = $request->input('gutt');
        $treatment->oc = $request->input('oc');
        $treatment->sur = $request->input('sur');
        $treatment->rtc = $request->input('rtc');
        $treatment->prescription = $request->input('prescription');
        $treatment->remark = $request->input('remark');
        $treatment->single_vision = isset($validatedData['singlevision']) ? json_encode($validatedData['singlevision']) : null;
        $treatment->bifocal = isset($validatedData['bifocal']) ? json_encode($validatedData['bifocal']) : null;
        $treatment->special_order = isset($validatedData['specialorder']) ? json_encode($validatedData['specialorder']) : null;
        $treatment->progressive = isset($validatedData['progressive']) ? json_encode($validatedData['progressive']) : null;
        $treatment->invisible = isset($validatedData['invisible']) ? json_encode($validatedData['invisible']) : null;
        $treatment->save();
    
        // Show the patient's treatment history, with the new plan on it.
        return redirect(route('search.get', ['query' => $treatment->patient_id]))
            ->with('success', 'Treatment plan and prescription saved.');
    }
    
    
}
