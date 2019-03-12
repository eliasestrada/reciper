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
            'email' => '1990serzhil@gmail.com',
            'username' => 'master',
            'name' => 'Серый 🍆',
            'xp' => config('custom.xp_for_approve') * 2,
            'popularity' => config('custom.popularity_for_like'),
            'status' => 'Always code as if the guy who ends up maintaining your code will be a violent psychopath who knows where you live.',
            'token' => null,
            'streak_days' => 0,
            'password' => bcrypt('11111111'),
            'notif_check' => date("Y-m-d H:i:s"),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => '2018-03-08 12:08:59',
            'photo' => '2018/11/master.jpg',
        ]);
        $user->addRole('admin');
        $user->addRole('master');

        User::create([
            'email' => null,
            'username' => 'irina',
            'name' => 'Ирен 👑',
            'xp' => 26,
            'popularity' => 0,
            'status' => null,
            'email' => null,
            'token' => 'none',
            'streak_days' => 0,
            'password' => bcrypt('11111111'),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'photo' => '2018/11/irina.jpg',
        ]);
    }
}
