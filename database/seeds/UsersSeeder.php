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
			'email'         => '1990serzhil@gmail.com',
			'name'          => 'Серый',
			'admin'         => 1,
			'author'        => 1,
			'password'      => '$2y$10$GYXbndwPHbGZhE.SJcuYpeHE7qYlgEenW7Gktm1es/o71r94UpQQq',
			'notif_check'   => date("Y-m-d H:i:s"),
			'contact_check' => date("Y-m-d H:i:s"),
			'image'         => 'user1.jpg'
		]);
    }
}