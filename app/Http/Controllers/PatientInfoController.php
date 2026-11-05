<?php

namespace App\Http\Controllers;

use App\Models\PatientInfo;
use Illuminate\Http\Request;

class PatientInfoController extends Controller
{

public function update(Request $request, $id)
{
    $patient = PatientInfo::findOrFail($id);
    // dd($request->all());


    $patient->update([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'fullname' => $request->input('fullname'),
        'patient_id' => $request->input('patient_id'),
        'gender' => $request->input('gender'),
        'phone' => $request->input('phone'),
        'street' => $request->input('street'),
        'occupation' => $request->input('occupation'),
        'age' => $request->input('age'),
    ]);

    // return redirect()->back()->with('success', 'Patient updated successfully!');
     return redirect(route('pages.status'))->with('success', 'Patient details updated.');
}



}
