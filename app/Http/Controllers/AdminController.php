<?php

namespace App\Http\Controllers;

use App\Exports\AdminExport;
use App\Exports\UsersExport;
use App\Models\Admin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Console\Migrations\RefreshCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }

    public function sub_admins(Request $request)
    {

        if ($request->filled('search')) {
            $admins = Admin::where('sub_admin', '=', 0)
                ->where(
                    function ($query) {
                        return $query
                            ->where('id', 'Like', '%' . request('search') . '%')
                            ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                            ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                            ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                            ->orwhere('email', 'Like', '%' . request('search') . '%');
                    })->paginate(10);
            if ($request->filled('filter') or $request->filled('export')) {

                if ($request->filter == 0 and $request->export == 1) {
                    $admins;
                    $pdf = Pdf::loadView('admin.myPDF', compact('admins'));
                    return $pdf->download('itsolutionstuff.pdf');

                } elseif ($request->filter == 0 and $request->export == 2) {
                    $admins;
                    return Excel::download(new AdminExport($admins), 'users-collection.xlsx');
                } elseif ($request->filter == 0 and $request->export == 3) {
                    $admins;
                    return (new AdminExport($admins))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 0) {
                    $admins;
                }

                if ($request->filter == 1 and $request->export == 1) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('first_name')->paginate(10);
                    $pdf = Pdf::loadView('admin.myPDF', compact('admins'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 1 and $request->export == 2) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('first_name')->paginate(10);
                    return Excel::download(new AdminExport($admins), 'users-collection.xlsx');
                } elseif ($request->filter == 1 and $request->export == 3) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('first_name')->paginate(10);
                    return (new AdminExport($admins))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 1) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('first_name')->paginate(10);
                }

                if ($request->filter == 2 and $request->export == 1) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('id', 'DESC')->paginate(10);
                    $pdf = Pdf::loadView('admin.myPDF', compact('admins'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 2 and $request->export == 2) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('id', 'DESC')->paginate(10);
                    return Excel::download(new AdminExport($admins), 'users-collection.xlsx');
                } elseif ($request->filter == 2 and $request->export == 3) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('id', 'DESC')->paginate(10);
                    return (new AdminExport($admins))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 2) {
                    $admins = Admin::where('sub_admin', '=', 0)
                        ->where(
                            function ($query) {
                                return $query
                                    ->where('id', 'Like', '%' . request('search') . '%')
                                    ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                    ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                    ->orwhere('email', 'Like', '%' . request('search') . '%');
                            })->orderBy('id', 'DESC')->paginate(10);
                }
            }

        } elseif ($request->filled('filter')) {

            if ($request->filter == 1 and $request->export == 1) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('first_name')->paginate(10);
                $pdf = Pdf::loadView('admin.myPDF', compact('admins'));
                return $pdf->download('itsolutionstuff.pdf');
            } elseif ($request->filter == 1 and $request->export == 2) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('first_name')->paginate(10);
                return Excel::download(new AdminExport($admins), 'users-collection.xlsx');
            } elseif ($request->filter == 1 and $request->export == 3) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('first_name')->paginate(10);
                return (new AdminExport($admins))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 1) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('first_name')->paginate(10);


            } elseif ($request->filter == 2 and $request->export == 1) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('id', 'DESC')->paginate(10);
                $pdf = Pdf::loadView('admin.myPDF', compact('admins'));
                return $pdf->download('Most_orders.pdf');
            } elseif ($request->filter == 2 and $request->export == 2) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('id', 'DESC')->paginate(10);
                return Excel::download(new AdminExport($admins), 'users-collection.xlsx');
            } elseif ($request->filter == 2 and $request->export == 3) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('id', 'DESC')->paginate(10);
                return (new AdminExport($admins))->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 2) {
                $admins = Admin::where('sub_admin', '=', 0)->orderBy('id', 'DESC')->paginate(10);


            } elseif ($request->filter == 0 and $request->export == 1) {
                $admins = Admin::where('sub_admin', '=', 0)->paginate(10);
                $pdf = Pdf::loadView('admin.myPDF', compact('admins'));
                return $pdf->download('Date_of_registration.pdf');
            } elseif ($request->filter == 0 and $request->export == 2) {
                $admins = Admin::where('sub_admin', '=', 0)->where('sub_admin', 0)->paginate(10);
                return Excel::download(new AdminExport($admins), 'users-collection.xlsx');
            } elseif ($request->filter == 0 and $request->export == 3) {
                $admins = Admin::where('sub_admin', '=', 0)->where('sub_admin', 0)->paginate(10);
                return (new AdminExport($admins))->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 0) {

                $admins = Admin::where('sub_admin', '=', 0)->paginate(10);
            }

        } else {
            $admins = Admin::where('sub_admin', 0)->paginate(10);
        }




        return view('admin.sub_admins.index', compact('admins'));
    }


    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.sub_admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'mobile' => 'required',
            'status' => 'required',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['sub_admin'] = 0;
        $input['image'] = 'files/users-1.jpg';

        $user = Admin::create($input);

        $user->assignRole($request->input('roles'));


        return redirect()->route('sub_admins')
            ->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $admin->roles->pluck('name', 'name')->all();

        return view('admin.sub_admins.edit', compact('admin', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => 'required',
            'status' => 'required',
            'roles' => 'required'
        ]);



        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = Admin::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('sub_admins')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
        return redirect()->route('sub_admins')->with('success', 'User deleted successfully');
    }
}