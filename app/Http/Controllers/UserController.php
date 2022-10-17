<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = Admin::orderBy('id', 'DESC')->paginate(5);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'mobile' => 'required',
            'status' => 'sometimes',
            'roles' => 'required|array|min:1'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

//        try {
//            DB::beginTransaction();
//
//            $user = Admin::create($input);
//            $user->roles()->sync($request->roles);
//
//            $user->assignRole($request->input('roles'));
//            DB::commit();
//        } catch (\Exception $exception) {
//            DB::rollBack();
//
//            return $exception->getMessage();
//        }
        $user = Admin::create($input);

        $user->assignRole($request->input('roles'));


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
        $user = Admin::find($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
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

        $user = Admin::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {

        Admin::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function profile()
    {
        $user = Auth::user();
        $users = Auth::user()->id;
        $Address = Address::where('user_id', $users)->orderBy('id', 'ASC')->get();
        return view('profile.index', compact('user', 'Address'));
    }

    public function edit_profile(User $user)
    {
        return view('profile.edit', compact('user'));
    }

    public function update_profile(User $user, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'same:confirm-password',
            'mobile' => 'sometimes',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($user->id);
        $user->update($input);

        return redirect()->route('profile_user', ['id' => $user->id]);
    }

    public function add_address(Address $address, Request $request, User $user)
    {
        $request->validate([
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

        $user = Auth::user()->id;
        $input = $request->all();

        $input['user_id'] = Auth::user()->id;
        Address::create($input);

        return redirect()->back();
    }

    public function edit_address(Address $address, Request $request, User $user)
    {
        return view('profile.address', compact('address', 'user'));

    }

    public function update_address(Address $address, Request $request, User $user)
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

        $Address = Address::find($address->id);
        $Address->update($input);

        return redirect()->route('profile_user', ['id' => $user]);

    }

    public function destroy_address(Address $address, User $user)
    {
        Address::find($address->id)->delete();
        return redirect()->route('profile_user', ['id' => $user->id]);

    }
}
