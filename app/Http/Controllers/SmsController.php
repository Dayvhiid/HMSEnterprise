<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
{
        public function index(Request $request){
                $email = $_GET['phone'];
                if(isset($_GET['submit'])){
                    echo "It is working";
                }
        }
        public function pass(Appointment $sms){
                 return view('doctors.sms', ['sms' => $sms]);
        }

        // Sends an SMS through NigeriaBulkSMS. Credentials come from config/services.php (.env), never from code.
        public function NaijaSMS(Request $request){
            $request->validate([
                'phone' => 'required|string|max:255',
                'message' => 'required|string|max:918',
            ]);

            $config = config('services.nigeriabulksms');
            if (blank($config['username'] ?? null) || blank($config['password'] ?? null)) {
                return redirect(route('doctors.status'))->with('msg', 'SMS is not set up yet. Ask the administrator to add the SMS account details.')->with('status_type', 'error');
            }

            try {
                $response = Http::timeout(15)->get('https://portal.nigeriabulksms.com/api/', [
                    'username' => $config['username'],
                    'password' => $config['password'],
                    'sender' => $config['sender'] ?: config('clinic.sms_sender'),
                    'message' => $request->input('message'),
                    'mobiles' => $request->input('phone'),
                ]);
            } catch (\Throwable $e) {
                Log::warning('SMS could not reach the provider: '.$e->getMessage());
                return redirect(route('doctors.status'))->with('msg', 'Message not sent: the SMS service could not be reached. Check the internet connection and try again.')->with('status_type', 'error');
            }

            $result = $response->json();
            if ($response->successful() && strtoupper((string) ($result['status'] ?? '')) === 'OK') {
                return redirect(route('doctors.status'))->with('msg', 'Message sent to the patient successfully.');
            }

            Log::warning('SMS provider rejected the message', ['error' => $result['error'] ?? $response->status()]);
            return redirect(route('doctors.status'))->with('msg', 'Message not sent: '.($result['error'] ?? 'the SMS service did not confirm delivery.'))->with('status_type', 'error');
        }

}
