<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::create([
            'first_name' => 'Wesam',
            'last_name' => 'Ashour',
            'email' => 'wesam@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'mobile' => '05999999',
            'image' => 'files/users-1.jpg',

        ]);

        $role = Role::create(['guard_name' => 'admin','name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
