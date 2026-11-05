<?php

namespace App\Http\Controllers;

use App\Models\PatientInfo;
use App\Models\Treat;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\vital2;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VitalsController extends Controller
{
    // Database column => form input name. Shared by store() and update() so saving and editing can't drift apart.
    // odaxis / osaxis hold Near VA (the original intent). Before 2026-11-04 they were wrongly filled from the lensometry axis.
    private const VITAL_FIELDS = [
        'patient_code' => 'patient_code',
        'cc' => 'cc',
        'pohx' => 'pohx',
        'lee' => 'lee',
        'pmhx' => 'pmhx',
        'pfohx' => 'pfohx',
        'odunaided' => 'ODunaided',
        'odpinhole' => 'ODpinhole',
        'odaxis' => 'ODnearVA', // right-eye Near VA
        'osunaided' => 'OSunaided',
        'ospinhole' => 'OSpinhole',
        'osaxis' => 'OSnearVA', // left-eye Near VA
        'lodsph' => 'ODSPH',
        'lodcyl' => 'ODCYL',
        'lodaxis' => 'ODAXIS',
        'lodva' => 'ODVA',
        'lossph' => 'OSSPH',
        'loscyl' => 'OSCYL',
        'losaxis' => 'OSAXIS',
        'losva' => 'OSVA',
        'addsph' => 'ADDSPH',
        'addcyl' => 'ADDCYL',
        'addaxis' => 'ADDAXIS',
        'addva' => 'ADDVA',
        'arodsphere' => 'arodsph',
        'arodcyl' => 'arodcyl',
        'arodaxis' => 'arodaxis',
        'arossphere' => 'arosph',
        'aroscyl' => 'aroscyl',
        'arosaxis' => 'arosaxis',
        'arpd' => 'arpd',
        'rodsph' => 'rodsph',
        'rodcyl' => 'rodcyl',
        'rodaxis' => 'rodaxis',
        'rossph' => 'rossph',
        'roscyl' => 'roscyl',
        'rosaxis' => 'rosaxis',
        'srodsphere' => 'srodsph',
        'srodcyl' => 'srodcyl',
        'srodaxis' => 'srodaxis',
        'srodva' => 'srodva',
        'srodadd' => 'srodadd',
        'srodnva' => 'srodnva',
        'fodsph' => 'fodsph',
        'fodcyl' => 'fodcyl',
        'fodaxis' => 'fodaxis',
        'fodva' => 'fodva',
        'fodadd' => 'fodadd',
        'fodnva' => 'fodnva',
        'eyelidod' => 'eyelidod',
        'eyelidos' => 'eyelidos',
        'conjuctivaod' => 'conjuctivaod',
        'conjuctivaos' => 'conjuctivaos',
        'corneaod' => 'corneaod',
        'corneaos' => 'corneaos',
        'pupilod' => 'pupilod',
        'pupilos' => 'pupilos',
        'irisod' => 'irisod',
        'irisos' => 'irisos',
        'lensod' => 'lensod',
        'lensos' => 'lensos',
        'vitreousod' => 'vitreousod',
        'vitreousos' => 'vitreousos',
        'cdratiood' => 'cdratiood',
        'cdratioos' => 'cdratioos',
        'macularod' => 'macularod',
        'maculaos' => 'maculaos',
        'odccct' => 'odccct',
        'odnct' => 'odnct',
        'oscct' => 'oscct',
        'osnct' => 'osnct',
        'iop_taken_at' => 'iop_taken_at',
    ];

    // Left-eye subjective refraction and final RX live in the vital2s table.
    private const VITAL2_FIELDS = [
        'srosphere' => 'srosph',
        'patient_code' => 'patient_code',
        'sroscyl' => 'sroscyl',
        'srosaxis' => 'srosaxis',
        'srosva' => 'srosva',
        'srosadd' => 'srosadd',
        'srosnva' => 'srosnva',
        'fossph' => 'fossph',
        'foscyl' => 'foscyl',
        'fosaxis' => 'fosaxis',
        'fosva' => 'fosva',
        'fosadd' => 'fosadd',
        'fosnva' => 'fosnva',
    ];

    private function validateVitals(Request $request): void
    {
        $request->validate([
            'patient_code' => 'required|string|max:255',
            'arpd' => 'nullable|numeric|between:40,85',
            'iop_taken_at' => 'nullable|date',
        ], [
            'patient_code.required' => 'Enter the Patient ID before saving.',
            'iop_taken_at.date' => 'The IOP date and time is not a valid date.',
            'arpd.numeric' => 'P.D. must be a number in millimetres, e.g. 62.',
            'arpd.between' => 'P.D. must be between 40 and 85 mm.',
        ]);
    }

    private function fieldsFromRequest(Request $request, array $map): array
    {
        return collect($map)->map(fn ($input) => $request->input($input))->all();
    }

    private function vitalsPageUrl(string $patientCode): string
    {
        return route('vitals.get', ['query' => $patientCode]);
    }

    public function store(Request $request)
{
    $this->validateVitals($request);

    $data = $this->fieldsFromRequest($request, self::VITAL_FIELDS);
    $data2 = $this->fieldsFromRequest($request, self::VITAL2_FIELDS);

    // Every opened form carries a one-time token. A second submit of the same form
    // (double click, browser Back then Save, a second tab) is ignored instead of saved again.
    // Forms opened before this existed have no token and are saved as before.
    $token = $request->input('form_token');
    if ($token && ! Cache::add('vitals_form_token:'.$token, true, now()->addDays(2))) {
        return redirect($this->vitalsPageUrl($data['patient_code']))
            ->with('info', 'This exam was already saved, so it was not saved again. You can edit it below.');
    }

    try {
        // Each visit is one vitals row plus one vital2 row; save both or neither.
        DB::transaction(function () use ($data, $data2) {
            Vital::create($data);
            vital2::create($data2);
        });
    } catch (\Throwable $e) {
        if ($token) {
            Cache::forget('vitals_form_token:'.$token);
        }
        throw $e;
    }

    // Optionally, you can return a response or redirect
    // Show the patient's visits, with the new exam at the top.
    return redirect($this->vitalsPageUrl($data['patient_code']))->with('success', 'Exam saved.');
}

    // Printable spectacle prescription (Final RX) for one visit, on the clinic letterhead.
    public function prescription(Vital $vital)
{
    $vital2 = $vital->pairedVital2();
    $patient = PatientInfo::where('patient_id', $vital->patient_code)->first();

    $eye = fn (?\Illuminate\Database\Eloquent\Model $row, string $prefix) => [
        'sph' => $row?->getAttribute($prefix.'sph'),
        'cyl' => $row?->getAttribute($prefix.'cyl'),
        'axis' => $row?->getAttribute($prefix.'axis'),
        'va' => $row?->getAttribute($prefix.'va'),
        'add' => $row?->getAttribute($prefix.'add'),
        'nva' => $row?->getAttribute($prefix.'nva'),
    ];
    $rx = ['OD (Right)' => $eye($vital, 'fod'), 'OS (Left)' => $eye($vital2, 'fos')];
    $hasRx = collect($rx)->flatten()->filter(fn ($v) => filled($v))->isNotEmpty();

    return view('doctors.spectacle-rx', compact('vital', 'patient', 'rx', 'hasRx'));
}
    public function edit(Vital $vital)
{
    $vital2 = $vital->pairedVital2();

    // Form input name => saved value, so the vitals form opens pre-filled.
    $prefill = [];
    foreach (self::VITAL_FIELDS as $column => $input) {
        $prefill[$input] = $vital->getAttribute($column);
    }
    // datetime-local inputs need "2026-11-04T10:15".
    $prefill['iop_taken_at'] = $vital->iop_taken_at?->format('Y-m-d\TH:i');
    foreach (self::VITAL2_FIELDS as $column => $input) {
        if ($column !== 'patient_code') {
            $prefill[$input] = $vital2?->getAttribute($column);
        }
    }

    return view('doctors.newVitals', compact('vital', 'prefill'));
}

    public function update(Request $request, Vital $vital)
{
    // The patient on a saved visit can't be changed from the edit form.
    $request->merge(['patient_code' => $vital->patient_code]);
    $this->validateVitals($request);

    // Only fields present in the submitted form are changed, so a form that doesn't show a field
    // (e.g. the editable visit card) can never blank it.
    $present = fn (array $map) => array_filter($map, fn ($input) => $request->has($input));
    $data = $this->fieldsFromRequest($request, $present(self::VITAL_FIELDS));
    $data2 = $this->fieldsFromRequest($request, $present(self::VITAL2_FIELDS));

    DB::transaction(function () use ($vital, $data, $data2) {
        $vital2 = $vital->pairedVital2();
        $vital->update($data);
        if ($vital2) {
            $vital2->update($data2);
        } else {
            $vital2 = vital2::create($data2);
            // Keep it paired with this visit (pairing matches on save time).
            $vital2->forceFill(['created_at' => $vital->created_at])->save();
        }
    });

    return redirect($this->vitalsPageUrl($vital->patient_code))
        ->with('success', 'Vitals for the visit on '.$vital->created_at->format('F j, Y g:i A').' were updated.');
}


    public function show(){
        return view('doctors.searchtreatment');
    }
    public function search(){
        $search_text = (string) request()->query('query', '');
        $treatments = Treat::where('patient_id', $search_text)
        ->get();

        $examinations = Vital::where('patient_code', $search_text)->orderByDesc('created_at')->orderByDesc('id')->get()
            ->map(fn ($vital) => [
                'date' => $vital->created_at,
                'sections' => $vital->examSectionsTaken($vital->pairedVital2()),
            ]);

        // return view('doctors.treatmentresult', compact('users'));
         return view('doctors.newtreatmentresult', compact('treatments', 'examinations'));
    }
    public function display(){
        return view('doctors.searchvitals');
    }
    // public function vitals(){
    //     $search_text = (string) request()->query('query', '');
    //     $users = Vital::where('patient_code', $search_text)
    //     ->get(); 
    //     $usersone = vital2::where('patient_code', $search_text)
    //     ->get(); 
    //     $combinedResults = array_merge($users->toArray(), $usersone->toArray()); 
    //     dd($combinedResults);
    //     return view('doctors.vitalsresult', compact('combinedResults')); 

    // }
    public function vitals() {
        $search_text = (string) request()->query('query', '');

        // One entry per visit, newest first, each with its own left-eye (vital2) row.
        $visits = Vital::where('patient_code', $search_text)->orderByDesc('created_at')->orderByDesc('id')->get()
            ->map(fn ($vital) => ['vital' => $vital, 'vital2' => $vital->pairedVital2()]);

        // return view('doctors.vitalsresult', compact('combinedResults'));
        return view('doctors.vitalsresultTwo', ['visits' => $visits, 'patientCode' => $search_text]);
    }

    // public function vitals() {
    //     $search_text = (string) request()->query('query', '');
    
    //     $vitals1 = Vital::where('patient_code', $search_text)->get();
    //     $vitals2 = vital2::where('patient_code', $search_text)->get();
    
    //     // Merge the collections
    //     $combinedResults = $vitals1->merge($vitals2);
    
    //     return view('doctors.vitalsresult', compact('combinedResults'));
    // }
    
    
    
    
}
