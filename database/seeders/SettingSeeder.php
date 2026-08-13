<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate([
            'phone' => '0123456789',
        ], [
            'address' => '123 Main St, Cairo, Egypt',
            'email' => 'info@test.com',
            'facebook' => 'https://www.facebook.com',
            'twitter' => 'https://www.twitter.com',
            'linkedin' => 'https://www.linkedin.com',
            'instagram' => 'https://www.instagram.com',
            'youtube' => 'https://www.youtube.com',
        ]);


    }
}
