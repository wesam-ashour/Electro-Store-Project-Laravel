<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Models\Color;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('admin.materials.index',compact('materials'));
    }

    public function create()
    {
        $colors = Color::all();
        return view('admin.materials.create',compact('colors'));
    }

    public function store(StoreMaterialRequest $request)
    {
        $materials = Material::create($request->all('name','colors_id'));
        $colors = Material::latest()->first();
        $colors->color()->attach($request->colors_id);
        toastr()->success('Created Successfully', 'Create');
        return redirect()->route('materials.index');
    }

    public function store_ajax(StoreMaterialRequest $request)
    {
        $materials = Material::create($request->all('name','colors_id'));
        $colors = Material::latest()->first();
        $colors->color()->attach($request->colors_id);
        return response()->json(['success'=>'Data is successfully added']);
    }

    public function show(Material $material)
    {
        //
    }

    public function edit($id)
    {
        $materials = Material::find($id);
        $colors = Color::pluck('name','id')->all();
        $materialColors = $materials->color->pluck('name','id')->all();
        return view('admin.materials.edit', compact('materials','colors','materialColors'));
    }

    public function update(Request $request, Material $material)
    {
        Material::where('id', $material->id)->update($request->all('name'));
        $material_id = Material::find($material->id);
        $material_id->color()->sync($request->colors_id);
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
