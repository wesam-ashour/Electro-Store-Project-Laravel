<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class AdsController extends Controller
{

    public function index()
    {
        $ads = Ads::orderBy('order', 'asc')->get();
        return view('admin.ads.index', compact('ads'));
    }

    public function store(Request $request)
    {
         
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,gif,jpg|max:2048',
        ]);

        $input = $request->all();
        // dd($input);
        $input['celebrity_id'] = Auth::user()->id;
        $file = $request->file('image');
        $resized_img = Image::make($file);
        $resized_img->fit(720,90)->save($file);
        $fileName = 'ads-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('files', $fileName);
        $input['image'] = $path;
        $input['order'] = rand(0, 99999);

        $user = Ads::create($input);

        return redirect()->route('ads.index')
            ->with('success', 'Ads created successfully');
    }
    public function updateOrder(Request $request)
    {
        foreach ($request->order as $key => $order) {
            $post = Ads::find($order['id'])->update(['order' => $order['order']]);
        }
        return response('Update Successfully.', 200);
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
                // 'priority' => $request->priority,
            ]);

        } else {
            $brand = Ads::findOrFail($id);
            $brand->update([
                'name' => $request->name,
                'status' => $request->status,
                // 'priority' => $request->priority,
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
