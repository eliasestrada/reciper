<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => '11@11.com',
            'name' => 'Серый',
            'admin' => 1,
            'master' => 1,
            'password' => bcrypt('111111'),
            'notif_check' => date("Y-m-d H:i:s"),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => '2018-03-08 12:08:59',
            'image' => 'default.jpg',
        ]);
    }
}
