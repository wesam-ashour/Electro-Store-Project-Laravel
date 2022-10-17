<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    public function store(StoreColorRequest $request)
    {
        $color = Color::create($request->all('name', 'color'));
        toastr()->success('Created Successfully','Create');
        return redirect()->route('colors.index');
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function show(Color $color)
    {
        //
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(UpdateColorRequest $request, Color $color)
    {
        Color::where('id', $color->id)->update($request->all('name', 'color'));
        toastr()->info('Updated Successfully','Update');
        return redirect()->route('colors.index');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        toastr()->error('Deleted Successfully','Delete');
        return redirect()->route('colors.index');
    }
}
