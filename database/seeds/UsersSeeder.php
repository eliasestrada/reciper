<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::create([
			'email' => '11@11.com',
			'name' => 'Серый',
			'admin' => 1,
			'author' => 1,
			'password' => bcrypt('111111'),
			'notif_check' => date("Y-m-d H:i:s"),
			'contact_check' => date("Y-m-d H:i:s"),
			'image' => 'user1.jpg'
		]);

		User::create([
			'email' => '22@22.com',
			'name' => 'Ира',
			'admin' => 1,
			'author' => 1,
			'password' => bcrypt('111111'),
			'notif_check' => date("Y-m-d H:i:s"),
			'contact_check' => date("Y-m-d H:i:s"),
			'image' => 'user2.jpg'
		]);
    }
}