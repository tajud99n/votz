<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Setting::create([
            'site_name' => 'Votz', 
            'phone' => '+234 0000 00000', 
            'email' => 'info@votz.com', 
            'address'   => 'Lagos, Nigeria'
        ]);
    }
}
