<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAds;
use App\Http\Requests\UpdateAds;
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

    public function store(StoreAds $request)
    {

        $input = $request->all();
        // dd($input);
        $input['celebrity_id'] = Auth::user()->id;
        $file = $request->file('image');
        $resized_img = Image::make($file);
        $resized_img->fit(720, 90)->save($file);
        $fileName = 'ads-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('files', $fileName);
        $input['image'] = $path;
        $input['order'] = rand(0, 99999);

        $user = Ads::create($input);

        return redirect()->route('ads.index')
            ->with('success', 'Ads created successfully');
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $key => $order) {
            $post = Ads::find($order['id'])->update(['order' => $order['order']]);
        }
        return response('Update Successfully.', 200);
    }

    public function update(UpdateAds $request, $id)
    {

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
            ]);

        } else {
            $brand = Ads::findOrFail($id);
            $brand->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);
        }
        return redirect()->route('ads.index')
            ->with('success', 'Ads updated successfully');
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
