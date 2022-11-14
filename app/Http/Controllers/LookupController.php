<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLookup;
use App\Models\Lookup;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function index(Lookup $lookup)
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lookup  $lookup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }

    
    public function edit($id)
    {
        
        $lookups = Lookup::find($id)->get();
        return view('admin.social',compact('lookups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lookup  $lookup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLookup $request,$id)
    {
        Lookup::find($id)->update($request->input());
        toastr()->info('Updated Successfully', 'Update');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lookup  $lookup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lookup $lookup)
    {
        //
    }
}
