<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Infobip\Api\SmsApi; 
use Infobip\Configuration;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Illuminate\Http\Request;

class SendSMSController extends Controller
{
    //
   

    public function sendSMS(Request $request){
        $phoneNumber = request()->get('number'); 
        $message = request()->get('message');

        // The Infobip SDK is not installed and the key lives in .env; say so instead of crashing.
        if (! class_exists(Configuration::class) || blank(config('services.infobip.key'))) {
            return redirect(route('doctors.status'))->with('msg', 'Message not sent: this SMS service is not set up. Use the other SMS option or ask the administrator.')->with('status_type', 'error');
        }

        $configuration = new Configuration(
            host: (string) config('services.infobip.host'),
            apiKey: (string) config('services.infobip.key')
        );

        $sendSmsApi = new SmsApi(config: $configuration);

        $message = new SmsTextualMessage(
            destinations: [
                new SmsDestination(to: (string) $phoneNumber)
            ],
            from: (string) config('clinic.sms_sender'),
            text: (string) $message
        );
    
        $request = new SmsAdvancedTextualRequest(messages: [$message]);
    
        try {
            $smsResponse = $sendSmsApi->sendSmsMessage($request);
            return redirect(route('doctors.status'))->with('msg','Message sent to the patient successfully.'); 
        } catch (ApiException $apiException) {
            // return redirect(route('doctors.status'))->with('msg',$apiException->getMessage()); 
            return redirect(route('doctors.status'))->with('msg','Message not delivered. Please try again.')->with('status_type', 'error');
        }
    }
    public function loadPage(Appointment $sms){
        // $appointment = Appointment::all();
        return view('send-sms', compact('sms'));
    }
}
