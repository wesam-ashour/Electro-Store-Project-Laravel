<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;


class AdsController extends Controller
{

    public function index()
    {
        $ads = Ads::paginate(5);
        return view('admin.ads.index', compact('ads'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,gif,jpg|max:2048',
            'priority' => 'required',
        ]);

        $input = $request->all();

        $file = $request->file('image');
        $fileName = 'ads-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('files', $fileName);
        $input['image'] = $path;

        $user = Ads::create($input);

        return redirect()->route('ads.index')
            ->with('success', 'Ads created successfully');
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $ads = Ads::find($id);
        return view('admin.ads.edit', compact('ads'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'image' => 'sometimes|file|image|mimes:jpeg,png,gif,jpg|max:2048',
            'priority' => 'required',
        ]);

        if ($request->hasFile('image')) {

            $brand = Ads::findOrFail($id);

            $imagePath = $request->file('image');
            $imageName = 'ads-' . time() . '.' . $imagePath->getClientOriginalName();
            $path = $imagePath->storeAs('files', $imageName);
            unlink(storage_path('app/public/' . $brand->image));

            $brand->update([
                'name' => $request->name,
                'status' => $request->status,
                'image' => $path,
                'priority' => $request->priority,
            ]);

        } else {
            $brand = Ads::findOrFail($id);
            $brand->update([
                'name' => $request->name,
                'status' => $request->status,
                'priority' => $request->priority,
            ]);
        }


        return redirect()->route('ads.index')
            ->with('success', 'Ads updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $des = Ads::find($id)->delete();
        return redirect()->back()->with('success', 'Ads deleted successfully');
    }
}
