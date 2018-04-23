<?php

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::create([
			'user_id' => 1,
			'title' => 'Some title',
			'message' => 'Some message',
			'for_admins' => 0
		]);
    }
}
