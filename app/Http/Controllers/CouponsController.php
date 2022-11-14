<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storecoupons;
use App\Models\Celebrity;
use App\Models\Coupons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponsController extends Controller
{
    public function index()
    {
        $coupons  = Coupons::all();
        return view('admin.coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storecoupons $request)
    {
        $request['is_one_time']= 0;
        $coupons = Coupons::create($request->all());
        toastr()->success('Created Successfully', 'Create');
        return redirect()->route('coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function show(Coupons $coupons)
    {
        //
    }

    public function edit(Coupons $coupons,$id)
    {
        $coupons= Coupons::find($id);
        return view('admin.coupons.edit',compact('coupons'));

    }

    public function update(Request $request, $id)
    {
        $request['is_one_time']= 0;
        Coupons::find($id)->update($request->except(['_token', '_method']));
        toastr()->info('Updated Successfully', 'Update');
        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupons $coupons,$id)
    {
        $coupon = Coupons::find($id);
        $coupon->status = 0;
        $coupon->save();
        $coupon->delete();
        toastr()->error('Deleted Successfully', 'Delete');
        return redirect()->back();

    }
}
