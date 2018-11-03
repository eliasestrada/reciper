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
            'email' => '1990serzhil@gmail.com',
            'username' => 'master',
            'name' => 'Серый 🍆',
            'xp' => config('custom.xp_for_approve'),
            'popularity' => config('custom.popularity_for_like'),
            'status' => 'Always code as if the guy who ends up maintaining your code will be a violent psychopath who knows where you live.',
            'streak_days' => 0,
            'password' => bcrypt('111111'),
            'notif_check' => date("Y-m-d H:i:s"),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => '2018-03-08 12:08:59',
            'photo' => '2018/11/maser.jpg',
        ]);
        $user->addRole('admin');
        $user->addRole('master');

        User::create([
            'visitor_id' => 1,
            'email' => null,
            'username' => 'irina',
            'name' => 'Ирен 👑',
            'xp' => 26,
            'popularity' => 0,
            'status' => null,
            'streak_days' => 0,
            'password' => bcrypt('111111'),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'photo' => '2018/11/irina.jpg',
        ]);
    }
}
