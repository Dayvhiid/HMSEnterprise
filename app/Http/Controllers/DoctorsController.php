<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Vital;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Support\PatientChart;

class DoctorsController extends Controller
{

    public function index(){
        return view('doctors.signup');
    }
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);
         $name = $data['name'];
         $password = $data['password'];
         $confirm_password = $data['confirm_password'];
        //  $search = Doctor::all();
         $search = Doctor::where('name', $name)->get(); // Find names that start with "category"
         if($search->isEmpty()){//change back to search
            if($password == $confirm_password){
                $hashedPassword = bcrypt($password);
                $doctor = new Doctor();
                $doctor->name = $name;
                $doctor->password = $hashedPassword;
                $doctor->save();
                return redirect(route('doctors.status'))->with('msg','Doctor account created succesfully'); 
             } else {
                return redirect(route('doctors.status'))->with('msg','Passwords do not match'); 
             }
         }else {
            return redirect(route('doctors.status'))->with('msg','User Already Exists'); 
         }
        // return view('doctors.signup');
    }

    public function signin(){
        return view('doctors.signin');
    }
   
    public function check(Request $request){
        //This function handles the signing in logic
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        $search = Doctor::where('name', $data['name'])->get();
        if (count($search) === 0) {
            // No results found
            return redirect(route('doctors.status'))->with('msg','Invalid Input details'); 
        } else {
            // Handle results (process $search)
            if(password_verify($data['password'], $search[0]['password'])){
                return redirect(route('doctors.index'));
                error_log('Password Correct');
          } else {
            return redirect(route('doctors.status'))->with('msg','Invalid Input details'); 
            
          }
        }

    }


    public function show(){
        $appointments = Appointment::latest()->limit(5)->get();
        $notifications = Notification::latest()->limit(7)->get();
        return view('doctors.index', compact('appointments','notifications')   );
    }

    public function testShow(){
         $appointments = Appointment::latest()->limit(5)->get();
        $notifications = Notification::latest()->limit(7)->get();
        return view('doctors.indexTwo', compact('appointments','notifications'));
    }

    

    public function vitals(Request $request){
        // ?patient= comes from the chart's "Record examination" link; after a failed save the typed ID wins.
        $patientCode = trim((string) old('patient_code', $request->query('patient', '')));

        return view('doctors.newVitals', [
            'patientCode' => $patientCode,
            'chart' => PatientChart::forPatientId($patientCode),
        ]);
    }

    public function vitalSave(){
        $vitals = new Vital();
        // $vitals->patient_id = 
    }
   

}
