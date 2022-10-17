<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Image;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['required'],
            'mobile' => ['sometimes'],

        ]);

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $fileName = 'ads-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('files', $fileName);
            $input['image'] = $path;

            $admin = Admin::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile' => '1212212',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' =>$path
            ]);

            $admin->assignRole('Admin');

        }

        event(new Registered($admin));

        Auth::guard('admin')->login($admin);

        return redirect(RouteServiceProvider::ADMIN_HOME);
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.register');
    }
}
