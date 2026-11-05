<?php

namespace App\Http\Controllers;

use App\Models\Lens;
use Illuminate\Http\Request;

class LensController extends Controller
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
        // Show the list with the new lenses on it, instead of a dead-end status page.
        return redirect(route('lens.list'))->with('success', 'Lens list updated.');
    }
    public function list(Request $request){
        $query = trim((string) $request->query('query', ''));
        $lens = Lens::query()
            ->when($query !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'LIKE', "%{$query}%")
                ->orWhere('special_code', 'LIKE', "%{$query}%")))
            ->orderBy('name')->orderBy('id')
            ->paginate(25)
            ->withQueryString();

        return view('lens.lenslist', ['lens' => $lens, 'query' => $query]);
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
    $ln = Lens::findOrFail($len);
    $ln->delete();
    return redirect(route('lens.list'))->with('success', 'Lens "'.$ln->name.'" deleted.');
}  
}
