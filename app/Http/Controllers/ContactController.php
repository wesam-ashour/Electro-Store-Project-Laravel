<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchContact;
use App\Http\Requests\StoreContact;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index(SearchContact $request)
    {

        $submisions = Contact::orderBy('id', 'asc')->paginate(10);

        if ($request->filled('search')) {

            $submisions = Contact::
            where('name', 'Like', '%' . request('search') . '%')
                ->orwhere('email', 'Like', '%' . request('search') . '%')
                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                ->orwhere('message', 'Like', '%' . request('search') . '%')
                ->paginate(10);
        } else {
            $submisions = Contact::orderBy('id', 'asc')->paginate(10);
        }


        return view('admin.contact.index', compact('submisions'));
    }


    public function send_submisions()
    {
        return view('contact');
    }

    public function store_submisions(StoreContact $request)
    {
        $submision = Contact::create($request->all('name', 'email', 'mobile', 'message'));
        toastr()->success('Created Successfully', 'Create');
        return redirect()->back();
    }

    public function about_us()
    {
        return view('aboutUs');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
