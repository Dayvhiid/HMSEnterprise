<?php

namespace App\Http\Controllers;
use App\Models\PatientInfo;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Exception;
class TwilioSmsController extends Controller
{
    public function index(){
        $user = PatientInfo::latest()->first();
        $recieverNumber = "$user->phone";
        $message = "Brymo Guess what i think its working";

        try{
             $account_sid = getenv("TWILIO_SID");
             $auth_token = getenv("TWILIO_TOKEN");
             $twilio_number = getenv("TWILIO_FROM");

             $client = new Client($account_sid, $auth_token);
             $client->messages->create($recieverNumber, [
                'from' => $twilio_number,
                'body' => $message
             ]);
             dd('SMS Sent succefully');
        } catch(Exception $e){
             dd("Error:". $e->getMessage());
        }
    }
    public function test()
{
    $today = now();
    $todayMonth = $today->month;
    $todayDay = $today->day;
    
    $birthdayUsers = PatientInfo::whereMonth('date', $todayMonth)
                                 ->whereDay('date', $todayDay)
                                 ->get();
    
    
    foreach ($birthdayUsers as $user) {
        $recieverNumber = $user->phone;
        $message = "Happy birthday, from all of us at ".config('clinic.name')."! Wishing you a day filled with brightness and clarity, just like your vision.Enjoy your special day !"; // Customize message as needed

        try {
            $account_sid = getenv("TWILIO_SID");
             $auth_token = getenv("TWILIO_TOKEN");
             $twilio_number = getenv("TWILIO_FROM");

             $client = new Client($account_sid, $auth_token);
             $client->messages->create($recieverNumber, [
                'from' => $twilio_number,
                'body' => $message
             ]);
            //  error_log("message sent succefully");
            dd('Birthday SMS sent successfully to ' . $user->last_name);
        } catch (Exception $e) {
            // error_log("message sent unsuccefully");
            dd("Error sending birthday SMS: " . $e->getMessage());
        }
    }
    // error_log("message sent succefully to null");
    dd('No birthdays to celebrate today!'); // If no matches found
}

public function playing(){
    error_log("It is working");
}

}
