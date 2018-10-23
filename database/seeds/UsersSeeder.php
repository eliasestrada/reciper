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
        $user = User::create([
            'visitor_id' => 1,
            'email' => '11@11.com',
            'username' => 'master',
            'name' => 'Серый 😎',
            'xp' => config('custom.xp_for_approve'),
            'popularity' => config('custom.popularity_for_like'),
            'status' => 'Always code as if the guy who ends up maintaining your code will be a violent psychopath who knows where you live.',
            'streak_days' => 253,
            'password' => bcrypt('111111'),
            'notif_check' => date("Y-m-d H:i:s"),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => '2018-03-08 12:08:59',
            'image' => '2018/10/1539031832-user1.jpg',
        ]);
        $user->addRole('admin');
        $user->addRole('master');

        User::create([
            'visitor_id' => 1,
            'email' => '22@22.com',
            'username' => 'kris',
            'name' => 'Кристина 👑',
            'xp' => 17,
            'popularity' => 5,
            'status' => 'Люблю Никитку',
            'streak_days' => 24,
            'password' => bcrypt('111111'),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => '2018-03-08 12:08:59',
            'image' => '2018/10/1539024731-user2.jpg',
        ]);
    }
}
