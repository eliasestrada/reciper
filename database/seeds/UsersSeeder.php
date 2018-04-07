<?php

use Illuminate\Database\Seeder;
use App\User;

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
			'email' => '1990serzhil@gmail.com',
			'name' => 'Серый',
			'admin' => 1,
			'author' => 1,
			'password' => '$2y$10$E0cRiYpu.5IVYAR71LRrO.Sr5l4aov6ED6jGxFwIJD3Sr4noD0.86',
			'notif_check' => date("Y-m-d H:i:s"),
			'contact_check' => date("Y-m-d H:i:s"),
			'image' => 'user1.jpg'
		]);
    }
}