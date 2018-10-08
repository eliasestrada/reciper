<?php

use App\Models\User;
use App\Models\Visitor;
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
            'visitor_id' => factory(Visitor::class)->create(['ip' => '127.0.0.1'])->id,
            'email' => '11@11.com',
            'name' => 'Серый 😎',
            'xp' => 57,
            'popularity' => 7,
            'about_me' => 'Always code as if the guy who ends up maintaining your code will be a violent psychopath who knows where you live.',
            'password' => bcrypt('111111'),
            'notif_check' => date("Y-m-d H:i:s"),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => '2018-03-08 12:08:59',
            'image' => '1539031832-user1.jpg',
        ]);
        $user->addRole('admin');
        $user->addRole('master');

        User::create([
            'visitor_id' => factory(Visitor::class)->create(['ip' => '127.0.0.2'])->id,
            'email' => '22@22.com',
            'name' => 'Кристина 👑',
            'xp' => 27,
            'popularity' => 5,
            'about_me' => 'Люблю Никитку',
            'password' => bcrypt('111111'),
            'contact_check' => date("Y-m-d H:i:s"),
            'created_at' => '2018-03-08 12:08:59',
            'image' => '1539024731-user2.jpg',
        ]);
    }
}
