<?php

namespace App\Http\Controllers;

use App\Exports\CelebrityExport;
use App\Models\Admin;
use App\Models\Celebrity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class CelebrityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('celebrity.dashboard', compact('user'));
    }
    public function celebrities_view(Request $request)
    {
        if ($request->filled('search')) {         
              
            $celebrities = Celebrity::where(
                function ($query) {
                    return $query
                        ->where('id', 'Like', '%' . request('search') . '%')
                        ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                        ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                        ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                        ->orwhere('username', 'Like', '%' . request('search') . '%');
                })->paginate(10);
            if ($request->filled('filter') or $request->filled('export')) {

                if ($request->filter == 0 and $request->export == 1) {
                    $celebrities;
                    $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 0 and $request->export == 2) {
                    $celebrities;
                    return Excel::download(new CelebrityExport($celebrities), 'users-collection.xlsx');
                } elseif ($request->filter == 0 and $request->export == 3) {
                    $celebrities;
                    return (new CelebrityExport($celebrities))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 0) {
                    $celebrities;
                }

                if ($request->filter == 1 and $request->export == 1) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('first_name')->paginate(10);
                    $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 1 and $request->export == 2) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('first_name')->paginate(10);
                    return Excel::download(new CelebrityExport($celebrities), 'users-collection.xlsx');
                } elseif ($request->filter == 1 and $request->export == 3) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('first_name')->paginate(10);
                    return (new CelebrityExport($celebrities))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 1) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('first_name')->paginate(10);
                }

                if ($request->filter == 2 and $request->export == 1) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('id', 'DESC')->paginate(10);
                    $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 2 and $request->export == 2) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('id', 'DESC')->paginate(10);
                    return Excel::download(new CelebrityExport($celebrities), 'users-collection.xlsx');
                } elseif ($request->filter == 2 and $request->export == 3) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('id', 'DESC')->paginate(10);
                    return (new CelebrityExport($celebrities))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 2) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        })->orderBy('id', 'DESC')->paginate(10);
                }
            }

        

        } elseif ($request->filled('filter')) {

            if ($request->filter == 1 and $request->export == 1) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);
                $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                return $pdf->download('itsolutionstuff.pdf');
            } elseif ($request->filter == 1 and $request->export == 2) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);
                return Excel::download(new CelebrityExport($celebrities), 'users-collection.xlsx');
            } elseif ($request->filter == 1 and $request->export == 3) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);
                return (new CelebrityExport($celebrities))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 1) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);


            } elseif ($request->filter == 2 and $request->export == 1) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);
                $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                return $pdf->download('Most_orders.pdf');
            } elseif ($request->filter == 2 and $request->export == 2) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);
                return Excel::download(new CelebrityExport($celebrities), 'users-collection.xlsx');
            } elseif ($request->filter == 2 and $request->export == 3) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);
                return (new CelebrityExport($celebrities))->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 2) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);


            } elseif ($request->filter == 0 and $request->export == 1) {
                $celebrities = Celebrity::paginate(10);
                $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                return $pdf->download('Date_of_registration.pdf');
            } elseif ($request->filter == 0 and $request->export == 2) {
                $celebrities = Celebrity::paginate(10);
                return Excel::download(new CelebrityExport($celebrities), 'users-collection.xlsx');
            } elseif ($request->filter == 0 and $request->export == 3) {
                $celebrities = Celebrity::paginate(10);
                return (new CelebrityExport($celebrities))->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 0) {
                $celebrities = Celebrity::paginate(10);
            }

        } else {
            $celebrities = Celebrity::paginate(10);
        }
        return view('admin.celebrities.index', compact('celebrities'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.celebrities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $admin_username = 'Admin: ' . ' ' . Admin::find($user)->first_name . ' ' . Admin::find($user)->last_name;
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:celebrities,username',
            'password' => 'required',
            'mobile' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['add_by'] = $admin_username;

        $user = Celebrity::create($input);

        return redirect()->route('celebrities_view')
            ->with('success', 'Celebrity created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Celebrity  $celebrity
     * @return \Illuminate\Http\Response
     */
    public function show(Celebrity $celebrity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Celebrity  $celebrity
     * @return \Illuminate\Http\Response
     */
    public function edit(Celebrity $celebrity)
    {
        return view('admin.celebrities.edit',compact('celebrity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Celebrity  $celebrity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:celebrities,username,' . $id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => 'required',
            'status' => 'required',
        ]);
        

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = Celebrity::find($id);
        
        $user->update($input);

        return redirect()->route('celebrities_view')
            ->with('success', 'Celebrity updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Celebrity  $celebrity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Celebrity::find($id)->delete();
        return redirect()->route('celebrities_view')
            ->with('success', 'Celebrity deleted successfully');
    }
}