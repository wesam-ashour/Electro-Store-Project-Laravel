<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Lookup::create([
            'facebook_url' => 'https://www.itsolutionstuff.com/',
            'instagram_url' => 'https://www.itsolutionstuff.com/',
            'twitter_url' => 'https://www.itsolutionstuff.com/',
            'snapchat_url' => 'https://www.itsolutionstuff.com/',
            'whatsApp_number' => '059999999',
        ]);
    }
}
