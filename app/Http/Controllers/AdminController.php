<?php

namespace App\Http\Controllers;

use App\Exports\AdminExport;
use App\Exports\UsersExport;
use App\Http\Requests\StoreSubAdmins;
use App\Models\Admin;
use App\Models\Celebrity;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Console\Migrations\RefreshCommand;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
   
    public function index()
    {
        $users = User::all()->count();
        $celebrities = Celebrity::all()->count();
        $orders = Order::all()->count();
        $transactions = Transaction::where('status',1)->count();
        $newOrders = Order::orderBy('id','DESC')->take(4)->get();
        $newTransactions = Transaction::where('status',1)->orderBy('id','DESC')->take(4)->get();
        $newMesseages = Contact::orderBy('id','DESC')->take(4)->get();

        return view('admin.home',compact('users','celebrities','orders','transactions','newOrders','newTransactions','newMesseages'));
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
                    }
                )->paginate(10);
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
                            }
                        )->orderBy('first_name')->paginate(10);
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
                            }
                        )->orderBy('first_name')->paginate(10);
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
                            }
                        )->orderBy('first_name')->paginate(10);
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
                            }
                        )->orderBy('first_name')->paginate(10);
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
                            }
                        )->orderBy('id', 'DESC')->paginate(10);
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
                            }
                        )->orderBy('id', 'DESC')->paginate(10);
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
                            }
                        )->orderBy('id', 'DESC')->paginate(10);
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
                            }
                        )->orderBy('id', 'DESC')->paginate(10);
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
    public function store(StoreSubAdmins $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['sub_admin'] = 0;
        $input['image'] = 'files/users-1.jpg';

        $user = Admin::create($input);

        $user->assignRole($request->input('roles'));
        return redirect()->route('sub_admins')
            ->with('success', 'SubAdmin created successfully');
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => ['required', 'string', 'max:15'],
            'status'  => 'required|min:1|max:50',
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
            ->with('success', 'SubAdmin updated successfully');
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
        return redirect()->route('sub_admins')->with('success', 'SubAdmin deleted successfully');
    }
    public function profile($id)
    {
       $admin =  Admin::find($id);
        return view('admin.auth.profile',compact('admin'));
    }
    public function update_profile_admin(Request $request,$id)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => ['required', 'string', 'max:15'],
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = Admin::find($id);
        $user->update($input);

        return redirect()->back()->with('success', 'Admin Information updated successfully');
    }
}