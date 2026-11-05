<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ServicesController extends Controller
{
      public function index(){
        return view('admin.admin2.services');
    }

      public function store(Request $request){
        $request->validate([
            // 'inputs.*.sn' => 'required',
            'inputs.*.name' => 'required',
            'inputs.*.price' => 'required',
            // 'inputs.*.special_code' => 'required',
        ]);

        foreach($request->inputs as $key => $value){
            Services::create($value);
        }
         return redirect(route('pages.status'))->with('success', 'Services list updated.');
        // return redirect(route('doctors.list'));
    }

     public function list(){
        $drugs = Services::paginate(9);
        return view('admin.admin2.servicesList', ['drugs' => $drugs]);
    }

      public function update(Request $request, $id)
     {
            $drug = Services::findOrFail($id);
            
            $data = $request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
            ]);
            
            $drug->update($data);
            
            return redirect(route('services.list'))->with('success', 'Drug updated successfully');
    }

       public function destroy(Services $drugs){
          $drugs->delete();
          return redirect(route('services.list'));
    }
}
