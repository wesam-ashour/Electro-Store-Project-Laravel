<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function store(StoreSizeRequest $request)
    {
        $size = Size::create($request->all('name'));
        toastr()->success('Created Successfully', 'Create');
        return redirect()->route('sizes.index');
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function show(Size $size)
    {
        //
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(UpdateSizeRequest $request, Size $size)
    {
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
