<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $sizes = Size::where('celebrity_id', $user)->get();
        return view('celebrity.sizes.index', compact('sizes'));
    }

    public function store(StoreSizeRequest $request)
    {
        $request['name'] = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $request['celebrity_id'] = Auth::user()->id;
        $size = Size::create($request->all('name', 'celebrity_id'));
        toastr()->success('Created Successfully', 'Create');
        return redirect()->route('sizes.index');
    }

    public function create()
    {
        return view('celebrity.sizes.create');
    }

    public function show(Size $size)
    {
        //
    }

    public function edit(Size $size)
    {
        return view('celebrity.sizes.edit', compact('size'));
    }

    public function update(UpdateSizeRequest $request, Size $size)
    {
        $request['name'] = ['en' => $request->name_en, 'ar' => $request->name_ar];
        Size::where('id', $size->id)->update($request->all('name'));
        toastr()->info('Updated Successfully', 'Update');
        return redirect()->route('sizes.index');
    }

    public function destroy(Size $size)
    {
        $size->delete();
        toastr()->error('Deleted Successfully', 'Delete');
        return redirect()->route('sizes.index');
    }
}
