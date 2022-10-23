<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $colors = Color::where('celebrity_id',$user)->get();
        return view('celebrity.colors.index', compact('colors'));
    }

    public function store(StoreColorRequest $request)
    {
        $request['celebrity_id']=Auth::user()->id;
        $color = Color::create($request->all('name', 'color','celebrity_id'));
        toastr()->success('Created Successfully','Create');
        return redirect()->route('colors.index');
    }

    public function create()
    {
        return view('celebrity.colors.create');
    }

    public function show(Color $color)
    {
        //
    }

    public function edit(Color $color)
    {
        return view('celebrity.colors.edit', compact('color'));
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
