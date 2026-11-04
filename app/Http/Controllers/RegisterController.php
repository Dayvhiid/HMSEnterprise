<?php

namespace App\Http\Controllers;

use App\Models\register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('register');
    }
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);
         $name = $data['name'];
         $password = $data['password'];
         $confirm_password = $data['confirm_password'];
        //  $search = Doctor::all();
         $search = register::where('name', $name)->get(); // Find names that start with "category"
         if($search->isEmpty()){//change back to search
            if($password == $confirm_password){
                $hashedPassword = bcrypt($password);
                $register = new register();
                $register->name = $name;
                $register->password = $hashedPassword;
                $register->save();
                return redirect(route('doctors.status'))->with('msg','account created sucesfully'); 
             } else {
                return redirect(route('doctors.status'))->with('msg','Passwords do not match'); 
             }
         }else {
            return redirect(route('doctors.status'))->with('msg','User Already Exists'); 
         }
        // return view('doctors.signup');
    }

    public function signin(){
        return view('regsignin');
    }

    public function check(Request $request){
        //This function handles the signing in logic
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        $search = register::where('name', $data['name'])->get();
        if (count($search) === 0) {
            // No results found
            return redirect(route('doctors.status'))->with('msg','Invalid Input details'); 
        } else {
            // Handle results (process $search)
            if(password_verify($data['password'], $search[0]['password'])){
                return redirect(route('pages.register'));
          } else {
            return redirect(route('doctors.status'))->with('msg','Wrong Password'); 
          }
        }

    }

}
