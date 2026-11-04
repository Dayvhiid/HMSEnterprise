<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PatientInfo;
use App\Models\Treat;
use App\Models\Vital;
use App\Models\User;
use Illuminate\Http\Request;

class PatientCardController extends Controller
{
    //
    public function index()
    {
        // Logic to display patient cards
        return view('patient_cards');
    }



    public function show($id)
{
    $user = PatientInfo::findOrFail($id);

    // Medical records are linked to the patient by patient ID (vitals.patient_code, treats.patient_id).
    $vitals = Vital::where('patient_code', $user->patient_id);
    $treatments = Treat::where('patient_id', $user->patient_id);
    $medicalRecords = [
        'vitalsCount' => $vitals->count(),
        'latestVital' => $vitals->max('created_at'),
        'treatmentsCount' => $treatments->count(),
        'latestTreatment' => $treatments->max('created_at'),
    ];

    return view('patient_cards', compact('user', 'medicalRecords'));
}

    public function edit($id)
{
    $user = PatientInfo::findOrFail($id);
    return view('patient_cards_edit', compact('user'));
}

    public function update(Request $request, $id)
{
    $user = PatientInfo::findOrFail($id);
    $user->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'fullname' => $request->fullname,
        'gender' => $request->gender,
        'phone' => $request->phone,
        'email' => $request->email,
        'street' => $request->street,
        'occupation' => $request->occupation,
        'emergency_fullname' => $request->emergency_fullname,
        'emergency_phone' => $request->emergency_phone,
        'datee' => $request->datee,
        'age' => $request->age,
    ]);
    return redirect(route('patient.show', $id))->with('success', 'Patient details updated successfully');
}

    // Only touches the summary fields, so saving a summary can never blank the patient's other details.
    public function updateSummary(Request $request, $id)
{
    $patient = PatientInfo::findOrFail($id);

    $validated = $request->validate([
        'summary' => 'nullable|string|max:5000',
    ], [
        'summary.max' => 'The patient summary cannot be longer than 5,000 characters.',
    ]);

    $patient->update([
        'summary' => $validated['summary'] ?? null,
        'summary_updated_by' => auth()->user()->name,
        'summary_updated_at' => now(),
    ]);

    return redirect(route('patient.show', $patient->id))->with('success', 'Patient summary saved.');
}

    public function redirectByPid($pid)
{
    $patient = PatientInfo::where('patient_id', $pid)->firstOrFail();
    return redirect(route('patient.show', $patient->id));
}

    // Notify doctors/opticians that an already-registered patient is back at the clinic.
    public function checkIn($id)
{
    $patient = PatientInfo::findOrFail($id);

    $alreadyCheckedIn = Notification::where('pid', $patient->patient_id)
        ->where('message', Notification::RETURNING_PATIENT)
        ->whereDate('created_at', today())
        ->exists();

    if ($alreadyCheckedIn) {
        return redirect(route('patient.show', $patient->id))->with('info', 'This patient has already been checked in today.');
    }

    $notification = new Notification();
    $notification->patient_name = ($patient->first_name && $patient->last_name)
        ? $patient->first_name . ' ' . $patient->last_name
        : $patient->fullname;
    $notification->message = Notification::RETURNING_PATIENT;
    $notification->added_by = auth()->user()->name;
    $notification->pid = $patient->patient_id;
    $notification->save();

    return redirect(route('patient.show', $patient->id))->with('success', 'Patient checked in. The doctors have been notified.');
}
}
