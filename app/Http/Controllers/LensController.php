<?php

namespace App\Http\Controllers;

use App\Models\Lens;
use Illuminate\Http\Request;

class lensController extends Controller
{
    public function index(){
        return view('lens.lens');
    }
    public function store(Request $request){
        $request->validate([
            // 'inputs.*.sn' => 'required',
            'inputs.*.name' => 'required',
            'inputs.*.price' => 'required',
            // 'inputs.*.special_code' => 'required',
            // 'inputs.*.drug_type' => 'required',
        ]);

        foreach($request->inputs as $key => $value){
            Lens::create($value);
        }
         return redirect(route('doctors.status'))->with('msg','Lenses List Updated Succesfully'); 
        // return redirect(route('lens.list'));
    }
    public function list(){
        $lens = Lens::paginate(9);
        return view('lens.lenslist', [ 'lens' => $lens]);
    }
    public function edit(Lens $len){
        return view('lens.edit', ['len' => $len]);
   }
   public function update(Lens $lens, Request $request){
    $data = $request->validate([
        'name' => 'required',
        'price' => 'required',
        'quantity' => 'required',
    ]);
    $lens->update($data); 
    return redirect(route('lens.list'));
  }
  public function delete($len){
    $ln = Lens::find($len);
    $ln->delete();
    // return redirect(route('pages.status'))->with('success', 'Lens deleted Sucesfully');
    return redirect(route('lens.list'));
}  
}
