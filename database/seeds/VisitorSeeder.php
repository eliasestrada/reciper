<?php

use App\Models\Visitor;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        factory(Visitor::class)->create(['ip' => '127.0.0.1']);
    }
}
