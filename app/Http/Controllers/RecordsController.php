<?php

namespace App\Http\Controllers;

use App\Models\PatientInfo;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function index(){
        return view('records.records');
    }
    public function search(){
        $search_text = (string) request()->query('query', '');
        $users = PatientInfo::where(function ($query) use ($search_text) {
            $query->where('first_name', 'LIKE', "%{$search_text}%")
                  ->orWhere('last_name', 'LIKE', "%{$search_text}%")
                  ->orWhere('patient_id', 'LIKE', "%{$search_text}%")
                   ->orWhere('fullname', 'LIKE', "%{$search_text}%");
        })
        ->get();
        
        return view('records.publicrecords', compact('users'));
    }
}
