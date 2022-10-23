<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Models\Color;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $materials = Material::where('celebrity_id',$user)->get();
        return view('celebrity.materials.index',compact('materials'));
    }

    public function create()
    {
        $colors = Color::all();
        return view('celebrity.materials.create',compact('colors'));
    }

    public function store(StoreMaterialRequest $request)
    {
        $request['celebrity_id']=Auth::user()->id;
        $materials = Material::create($request->all('name','colors_id','celebrity_id'));
        toastr()->success('Created Successfully', 'Create');
        return redirect()->route('materials.index');
    }

    public function show(Material $material)
    {
        //
    }

    public function edit($id)
    {
        $materials = Material::find($id);
        return view('celebrity.materials.edit', compact('materials'));
    }

    public function update(Request $request, Material $material)
    {
        Material::where('id', $material->id)->update($request->all('name'));
        toastr()->info('Updated Successfully', 'Update');
        return redirect()->route('materials.index');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        toastr()->error('Deleted Successfully', 'Delete');
        return redirect()->route('materials.index');
    }
}
