<?php

namespace App\Http\Controllers;

use App\Models\Treat;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\vital2;

class vitalsController extends Controller
{
    //
    public function store(Request $request)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        // Define your validation rules here
        // Example:
        // 'patient_code' => 'required|string|unique:vitals,patient_code', // Add your validation rules accordingly
        // 'cc' => 'required|string',
        // 'pohx' => 'required|string',
        // and so on...
    ]);

    // Prepare the data to be stored or updated
    $data = [
        'patient_code' => $request->input('patient_code'),
        'cc' => $request->input('cc'),
        'pohx' => $request->input('pohx'),
        'lee' => $request->input('lee'),
        'pmhx' => $request->input('pmhx'),
        'pfohx' => $request->input('pfohx'),
        'odunaided' => $request->input('ODunaided'),
        'odpinhole' => $request->input('ODpinhole'),
        'odaxis' => $request->input('ODAXIS'), //stroing od nearva as odaxis
        'osunaided' => $request->input('OSunaided'),
        'ospinhole' => $request->input('OSpinhole'),
        'osaxis' => $request->input('OSAXIS'), //STORING OD NEARVA AS ODAXIS
        'lodsph' => $request->input('ODSPH'),
        'lodcyl' => $request->input('ODCYL'),
        'lodaxis' => $request->input('ODAXIS'),
        'lodva' => $request->input('ODVA'),
        'lossph' => $request->input('OSSPH'),
        'loscyl' => $request->input('OSCYL'), 
        'losaxis' => $request->input('OSAXIS'),
        'losva' => $request->input('OSVA'),
        'addsph' => $request->input('ADDSPH'),
        'addcyl' => $request->input('ADDCYL'),
        'addaxis' => $request->input('ADDAXIS'),
        'addva' => $request->input('ADDVA'),
        'arodsphere' => $request->input('arodsph'),
        'arodcyl' => $request->input('arodcyl'),
        'arodaxis' => $request->input('arodaxis'),
        'arossphere' => $request->input('arosph'),
        'aroscyl' => $request->input('aroscyl'),
        'arosaxis' => $request->input('arosaxis'),
        'rodsph' => $request->input('rodsph'),
        'rodcyl' => $request->input('rodcyl'),
        'rodaxis' => $request->input('rodaxis'),
        'rossph' => $request->input('rossph'),
        'roscyl' => $request->input('roscyl'),
        'rosaxis' => $request->input('rosaxis'),
        'srodsphere' => $request->input('srodsph'),
        'srodcyl' => $request->input('srodcyl'),
        'srodaxis' => $request->input('srodaxis'),
        'srodva' => $request->input('srodva'),
        'srodadd' => $request->input('srodadd'),
        'srodnva' => $request->input('srodnva'),
        'fodsph' => $request->input('fodsph'),
        'fodcyl' => $request->input('fodcyl'),
        'fodaxis' => $request->input('fodaxis'),
        'fodva' => $request->input('fodva'),
        'fodadd' => $request->input('fodadd'),
        'fodnva' => $request->input('fodnva'),
        'eyelidod' => $request->input('eyelidod'),
        'eyelidos' => $request->input('eyelidos'),
        'conjuctivaod' => $request->input('conjuctivaod'),
        'conjuctivaos' => $request->input('conjuctivaos'),
        'corneaod' => $request->input('corneaod'),
        'corneaos' => $request->input('corneaos'),
        'pupilod' => $request->input('pupilod'),
        'pupilos' => $request->input('pupilos'),
        'irisod' => $request->input('irisod'),
        'irisos' => $request->input('irisos'),
        'lensod' => $request->input('lensod'),
        'lensos' => $request->input('lensos'),
        'vitreousod' => $request->input('vitreousod'),
        'vitreousos' => $request->input('vitreousos'),
        'cdratiood' => $request->input('cdratiood'),
        'cdratioos' => $request->input('cdratioos'),
        'macularod' => $request->input('macularod'),
        'maculaos' => $request->input('maculaos'),
        'odccct' => $request->input('odccct'),
        'odnct' => $request->input('odnct'),
        'oscct' => $request->input('oscct'),
        'osnct' => $request->input('osnct'),
    ];
    $data2 = [
        'srosphere' => $request->input('srosph'),
        'patient_code' => $request->input('patient_code'),
        'sroscyl' => $request->input('sroscyl'),
        'srosaxis' => $request->input('srosaxis'),
        'srosva' => $request->input('srosva'),
        'srosadd' => $request->input('srosadd'),
        'srosnva' => $request->input('srosnva'),
        'fossph' => $request->input('fossph'),
        'foscyl' => $request->input('foscyl'),
        'fosaxis' => $request->input('fosaxis'),
        'fosva' => $request->input('fosva'),
        'fosadd' => $request->input('fosadd'),
        'fosnva' => $request->input('fosnva'),
    ];
    
    // Check if the record exists
    $existingVital = Vital::where('patient_code', $data['patient_code'])->first();

    if ($existingVital) {
        // Update the existing record
        // $existingVital->update($data); 
        //I MANIPULATED THIS TO STORE MULTIPLE RECORDS OF THE SAME ID PLEASE THIS IS A MANIPULATION OOH
        $vital = Vital::create($data);
        $vitals = vital2::create($data2);
    } else {
        // Create a new record
        $vital = Vital::create($data);
        $vitals = vital2::create($data2);
    }

    // Optionally, you can return a response or redirect
    return redirect(route('doctors.status'))->with('msg','Patients Vitals Stored successfully'); 
}


    public function show(){
        return view('doctors.searchtreatment');
    }
    public function search(){
        $search_text = $_GET['query'];
        $treatments = Treat::where('patient_id', $search_text)
        ->get();        
        // return view('doctors.treatmentresult', compact('users'));
         return view('doctors.newtreatmentresult', compact('treatments'));
    }
    public function display(){
        return view('doctors.searchvitals');
    }
    // public function vitals(){
    //     $search_text = $_GET['query'];
    //     $users = Vital::where('patient_code', $search_text)
    //     ->get(); 
    //     $usersone = vital2::where('patient_code', $search_text)
    //     ->get(); 
    //     $combinedResults = array_merge($users->toArray(), $usersone->toArray()); 
    //     dd($combinedResults);
    //     return view('doctors.vitalsresult', compact('combinedResults')); 

    // }
    public function vitals() {
        $search_text = $_GET['query'];
        $combinedResults = [];
    
        Vital::where('patient_code', $search_text)->each(function ($vital) use (&$combinedResults) {
            $combinedResults[] = $vital;
        });
    
        vital2::where('patient_code', $search_text)->each(function ($vital2) use (&$combinedResults) {
            $combinedResults[] = $vital2;
        });

        //  if (!empty($combinedResults)) {
        //    dd($combinedResults[1]->toArray()); // This will show all available fields
        //    }
    
        // return view('doctors.vitalsresult', compact('combinedResults'));
        return view('doctors.vitalsresultTwo', ['combinedResults' => $combinedResults]);
    }

    // public function vitals() {
    //     $search_text = $_GET['query'];
    
    //     $vitals1 = Vital::where('patient_code', $search_text)->get();
    //     $vitals2 = vital2::where('patient_code', $search_text)->get();
    
    //     // Merge the collections
    //     $combinedResults = $vitals1->merge($vitals2);
    
    //     return view('doctors.vitalsresult', compact('combinedResults'));
    // }
    
    
    
    
}
