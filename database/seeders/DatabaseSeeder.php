<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CreateUserSeeder::class);
        $this->call(CreateCelebritySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(AdminSocialSeeder::class);
        $this->call(StatusSeeder::class);

    }
}
