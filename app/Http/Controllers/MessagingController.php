<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class MessagingController extends Controller
{
    public function index(){
        return view('appointment.bookappointment');
    }
    public function store(Request $request){
        $appointment = new Appointment();
        // $data = $request->validate([
        //     'name' => 'required',
        //     'date' => 'required',
        //     'time' => 'required',
        //     'complaints' => 'required',
        //     'phone number' => 'required'
        // ]);
        // $appointment->save($data);
        $appointment->name = $request->input('name');
        $appointment->date = $request->input('date');
        $appointment->time = $request->input('time');
        $appointment->complaints = $request->input('complaints');
        // $appointment->phone_number = $request->input('phone');
        $phoneNumber = $request->input('phone');

            // Check if phone number is empty to avoid errors
            if (!empty($phoneNumber)) {
            // Remove the first character and prepend "+234"
            $phoneNumber = preg_replace('/^\d/', '234', $phoneNumber, 1);
            $appointment->phone_number = $phoneNumber;
            } else {
            // Handle empty phone number case (optional)
            // You can set a default value or throw an error here
            }

        $appointment->save();
        return redirect(route('pages.status'))->with('success', 'Data captured we will get in touch with you soon ');
    }
}
