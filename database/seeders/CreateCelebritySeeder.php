<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Celebrity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateCelebritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Celebrity::create([
            'first_name' => 'ali',
            'last_name' => 'Ashour',
            'username' => 'user',
            'password' => bcrypt('password'),
            'mobile' => '05999999',
            'add_by' => 'seeder',
        ]);

    }
}
