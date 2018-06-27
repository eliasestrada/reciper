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
			'password' => bcrypt('111111'),
			'notif_check' => date("Y-m-d H:i:s"),
			'contact_check' => date("Y-m-d H:i:s"),
			'created_at' => '2018-03-08 12:08:59',
			'image' => 'user1.jpg'
		]);

		User::create([
			'email' => 'venera23091970@gmail.com',
			'name' => 'Ирен',
			'admin' => 1,
			'password' => '$2y$10$LjEPpSoZr8aJHIbruB6AfOlBNTdZIJUb6xZa31z.nYGNkxkeZI.zi',
			'notif_check' => date("Y-m-d H:i:s"),
			'contact_check' => date("Y-m-d H:i:s"),
			'created_at' => '2018-03-10 21:27:35',
			'image' => 'user2.jpg'
		]);

		User::create([
			'email' => '22@22.com',
			'name' => 'Ваня',
			'admin' => 0,
			'password' => bcrypt('111111'),
			'notif_check' => date("Y-m-d H:i:s"),
			'contact_check' => date("Y-m-d H:i:s"),
			'image' => 'default.jpg'
		]);
    }
}