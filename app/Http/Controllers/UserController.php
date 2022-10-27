<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    public function index(Request $request)
    {

        if ($request->filled('search')) {

            // $users = User::search($request->search)->paginate(10);

            $users = User::query()
                ->withCount('orders')
                ->where('id', 'Like', '%' . request('search') . '%')
                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                ->orwhere('email', 'Like', '%' . request('search') . '%')
                ->paginate(10);

            if ($request->filled('filter') or $request->filled('export')) {

                if ($request->filter == 0 and $request->export == 1) {
                    $users;
                    $pdf = Pdf::loadView('myPDF', compact('users'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 0 and $request->export == 2) {
                    $users;
                    return Excel::download(new UsersExport($users), 'users-collection.xlsx');
                } elseif ($request->filter == 0 and $request->export == 3) {
                    $users;
                    return (new UsersExport($users))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 0) {
                    $users;
                }

                if ($request->filter == 1 and $request->export == 1) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('first_name')->paginate(10);
                    $pdf = Pdf::loadView('myPDF', compact('users'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 1 and $request->export == 2) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('first_name')->paginate(10);
                    return Excel::download(new UsersExport($users), 'users-collection.xlsx');
                } elseif ($request->filter == 1 and $request->export == 3) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('first_name')->paginate(10);
                    return (new UsersExport($users))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 1) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('first_name')->paginate(10);
                }

                if ($request->filter == 2 and $request->export == 1) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->paginate(10);
                    $pdf = Pdf::loadView('myPDF', compact('users'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 2 and $request->export == 2) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->paginate(10);
                    return Excel::download(new UsersExport($users), 'users-collection.xlsx');
                } elseif ($request->filter == 2 and $request->export == 3) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->paginate(10);
                    return (new UsersExport($users))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 2) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->paginate(10);
                }

                if ($request->filter == 3 and $request->export == 1) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->orderBy('first_name')->paginate(10);
                    $pdf = Pdf::loadView('myPDF', compact('users'));
                    return $pdf->download('itsolutionstuff.pdf');
                } elseif ($request->filter == 3 and $request->export == 2) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->orderBy('first_name')->paginate(10);
                    return Excel::download(new UsersExport($users), 'users-collection.xlsx');
                } elseif ($request->filter == 3 and $request->export == 3) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->orderBy('first_name')->paginate(10);
                    return (new UsersExport($users))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 3) {
                    $users = User::query()->withCount('orders')->where('id', 'Like', '%' . request('search') . '%')->orwhere('first_name', 'Like', '%' . request('search') . '%')->orwhere('last_name', 'Like', '%' . request('search') . '%')->orwhere('mobile', 'Like', '%' . request('search') . '%')->orwhere('email', 'Like', '%' . request('search') . '%')->orderBy('orders_count', 'desc')->orderBy('first_name')->paginate(10);
                }

            }

        } elseif ($request->filled('filter')) {

            if ($request->filter == 1 and $request->export == 1) {
                $users = User::withCount('orders')->orderBy('first_name')->paginate(10);
                $pdf = Pdf::loadView('myPDF', compact('users'));
                return $pdf->download('itsolutionstuff.pdf');
            } elseif ($request->filter == 1 and $request->export == 2) {
                $users = User::withCount('orders')->orderBy('first_name')->paginate(10);
                return Excel::download(new UsersExport($users), 'users-collection.xlsx');
            } elseif ($request->filter == 1 and $request->export == 3) {
                $users = User::withCount('orders')->orderBy('first_name')->paginate(10);
                return (new UsersExport($users))->download('Alphabetical.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 1) {
                $users = User::withCount('orders')->orderBy('first_name')->paginate(10);


            } elseif ($request->filter == 2 and $request->export == 1) {
                $users = User::withCount('orders')->orderBy('orders_count', 'desc')->paginate(10);
                $pdf = Pdf::loadView('myPDF', compact('users'));
                return $pdf->download('Most_orders.pdf');
            } elseif ($request->filter == 2 and $request->export == 2) {
                $users = User::withCount('orders')->orderBy('orders_count', 'desc')->paginate(10);
                return Excel::download(new UsersExport($users), 'users-collection.xlsx');
            } elseif ($request->filter == 2 and $request->export == 3) {
                $users = User::withCount('orders')->orderBy('orders_count', 'desc')->paginate(10);
                return (new UsersExport($users))->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 2) {
                $users = User::withCount('orders')->orderBy('orders_count', 'desc')->paginate(10);


            } elseif ($request->filter == 3 and $request->export == 1) {
                $users = User::withCount('orders')->orderBy('id', 'DESC')->paginate(10);
                $pdf = Pdf::loadView('myPDF', compact('users'));
                return $pdf->download('Date_of_registration.pdf');
            } elseif ($request->filter == 3 and $request->export == 2) {
                $users = User::withCount('orders')->orderBy('id', 'DESC')->paginate(10);
                return Excel::download(new UsersExport($users), 'users-collection.xlsx');
            } elseif ($request->filter == 3 and $request->export == 3) {
                $users = User::withCount('orders')->orderBy('id', 'DESC')->paginate(10);
                return (new UsersExport($users))->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 3) {
                $users = User::withCount('orders')->orderBy('id', 'DESC')->paginate(10);


            } elseif ($request->filter == 0 and $request->export == 1) {
                $users = User::withCount('orders')->paginate(10);
                $pdf = Pdf::loadView('myPDF', compact('users'));
                return $pdf->download('Date_of_registration.pdf');
            } elseif ($request->filter == 0 and $request->export == 2) {
                $users = User::withCount('orders')->paginate(10);
                return Excel::download(new UsersExport($users), 'users-collection.xlsx');
            } elseif ($request->filter == 0 and $request->export == 3) {
                $users = User::withCount('orders')->paginate(10);
                return (new UsersExport($users))->download('invoices.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 0) {
                $users = User::withCount('orders')->orderBy('id', 'DESC')->paginate(10);
            }

        } else {
            $users = User::withCount('orders')->paginate(10);
        }
        return view('admin.users.index', compact('users'));
    }


    public function show_orders_user($id)
    {
        $orders = Order::where('user_id', $id)
            ->orderBy('id', 'ASC')
            ->paginate(5);
        return view('admin.users.orders', compact('orders'));
    }

    public function show_orders_details_user($id)
    {
        $orderDetails = OrderItem::where('order_id', $id)
            ->orderBy('id', 'ASC')
            ->paginate(5);
        return view('admin.users.orders_details', compact('orderDetails'));
    }

    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $admin_username = 'Admin: ' . ' ' . Admin::find($user)->first_name . ' ' . Admin::find($user)->last_name;

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'mobile' => 'required',
            'status' => 'sometimes',
            // 'roles' => 'required|array|min:1'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['add_by'] = $admin_username;

        $user = User::create($input);

        // $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('admin.users.create', compact('roles'));
    }

    public function show($id)
    {
        $users = User::find($id);
        $addresss = Address::where('user_id', $id)->orderBy('id', 'ASC')->get();
        return view('admin.users.show', compact('users', 'addresss'));
    }

    public function edit($id)
    {
        $users = User::find($id);
        // $roles = Role::pluck('name', 'name')->all();
        // $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => 'sometimes',
            'status' => 'sometimes',
            'roles' => 'sometimes'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        // DB::table('model_has_roles')->where('model_id', $id)->delete();

        // $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function profile()
    {
        $user = Auth::user();
        $users = Auth::user()->id;
        $addresss = Address::where('user_id', $users)->orderBy('id', 'ASC')->paginate(3);
        return view('user.profile.index', compact('user', 'addresss'));
    }

    public function edit_profile(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    public function update_profile(User $user, Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => 'required|string|max:255',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        toastr()->success('Updated Successfully', 'Update');

        $user = User::find($user->id);
        $user->update($input);

        return redirect()->route('profile_user', ['id' => $user->id]);
    }

    public function add_address(Address $address, Request $request, User $user)
    {
        $request->validate([
            'area' => ['required', 'string', 'max:255'],
            'block_no' => ['required', 'string', 'max:255'],
            'street_no' => ['required', 'string', 'max:255'],
            'building_type' => ['required', 'string', 'max:255'],
            'house_no' => ['required', 'string', 'max:255'],
            'building_no' => ['required', 'string', 'max:255'],
            'floor_no' => ['required', 'string', 'max:255'],
            'flat_no' => ['required', 'string', 'max:255'],
            'landmark' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user()->id;
        $input = $request->all();

        $input['user_id'] = $user;
        Address::create($input);

        toastr()->success('Created Successfully', 'Create');

        return redirect()->back();
    }

    public function edit_address(Address $address, Request $request, User $user)
    {
        return view('user.profile.edit_address', compact('address', 'user'));

    }

    public function update_address(Request $request, User $user, $id)
    {
        $user = Auth::user()->id;
        $this->validate($request, [
            'user_id' => ['sometimes', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'block_no' => ['required', 'string', 'max:255'],
            'street_no' => ['required', 'string', 'max:255'],
            'building_type' => ['required', 'string', 'max:255'],
            'house_no' => ['required', 'string', 'max:255'],
            'building_no' => ['required', 'string', 'max:255'],
            'floor_no' => ['required', 'string', 'max:255'],
            'flat_no' => ['required', 'string', 'max:255'],
            'landmark' => ['required', 'string', 'max:255'],
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $Address = Address::find($id);
        $Address->update($input);
        toastr()->success('Updated Successfully', 'Update');
        return redirect()->route('profile_user', ['id' => $user]);

    }

    public function destroy_address(Address $address, User $user)
    {

        Address::find($address->id)->delete();
        toastr()->error('Deleted Successfully', 'Delete Address');
        return redirect()->route('profile_user', ['id' => $user->id]);

    }
}