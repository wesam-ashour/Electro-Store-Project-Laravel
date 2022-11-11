<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([

            'status' => 'new',

        ]);

        Status::create([

            'status' => 'canceled',

        ]);
        
        Status::create([

            'status' => 'pending',

        ]);
        
        Status::create([

            'status' => 'being bagged',

        ]);
        Status::create([

            'status' => 'on the way',

        ]);
        Status::create([

            'status' => 'delivered',

        ]);

    }
}
