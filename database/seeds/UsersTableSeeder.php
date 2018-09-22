<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::create([
            'name'  => 'Admin',
            'email' => 'admin@votz.com',
            'password'  => bcrypt('password'),
             'admin'    => 1
        ]);

        App\Profile::create([
            'user_id' => $user->id,
            'avatar'  => '/uploads/profile/a.png',
            'description'   => 'Super Admin'
        ]);
    }
}
