<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Drug;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(){
        return view('doctors.inventory');
    }
    public function store(Request $request){
        $request->validate([
            'inputs.*.date' => 'required',
            'inputs.*.new_stock' => 'required',
            'inputs.*.name' => 'required',
            'inputs.*.patient_code' => 'required',
            'inputs.*.booklet_no' => 'required',
            'inputs.*.qty_in' => 'required',
            'inputs.*.qty_out' => 'required',
            'inputs.*.balance' => 'required',
        ]);

        foreach($request->inputs as $key => $value){
            Inventory::create($value);
        }
        return redirect(route('pages.status'))->with('success', 'Stock ledger updated.');
        // return redirect(route('inventory.list'));
       
    }
    public function search(){
        return view('inventory.search');
    }
    public function find(){
        $search_text = (string) request()->query('query', '');
        $drugs = Drug::where('name','LIKE', '%'.$search_text.'%')->get();
        return view('inventory.find', compact('drugs'));
        // return view('products.search', compact('products'));
    }
    public function list(){
        $item = Inventory::paginate(9);
        return view('inventory.list', ['item' => $item]);
    }
    public function delete($item){
       $test = Inventory::find($item);
       $test->delete();
       return redirect(route('inventory.list'));
    }

}
