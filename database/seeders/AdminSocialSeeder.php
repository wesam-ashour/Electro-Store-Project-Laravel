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
            'facebook_url' => 'https://www.facebokk.com/',
            'instagram_url' => 'https://www.instegram.com/',
            'twitter_url' => 'https://www.twitter.com/',
            'snapchat_url' => 'https://www.snapchat.com/',
            'whatsApp_number' => 'https://api.whatsapp.com/send?phone=970599999999',
        ]);
    }
}
