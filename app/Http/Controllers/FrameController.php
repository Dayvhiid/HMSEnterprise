<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\Request;

class FrameController extends Controller
{
    public function index(){
        return view('frame.frame');
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
            Frame::create($value);
        }
        return redirect(route('doctors.status'))->with('msg','Frame list updated.'); 
        // return redirect(route('frame.list'));
    }

    public function list(){
        $frames = Frame::paginate(9);
        return view('frame.framelist', [ 'frames' => $frames]);
    }
    public function edit(Frame $frames){
         return view('frame.edit', ['frames' => $frames]);
    }
    public function update(Frame $frames, Request $request){
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);
        $frames->update($data); 
        return redirect(route('frame.list'));
    }
    public function delete($frames){
        $frame = Frame::find($frames);
        $frame->delete();
        // return redirect(route('pages.status'))->with('success', 'Frame deleted Sucesfully');
        return redirect(route('frame.list'));
    }    
}

