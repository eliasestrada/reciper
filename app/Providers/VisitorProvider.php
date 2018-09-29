<?php

namespace App\Providers;

use App\Models\Visitor;
use Illuminate\Support\ServiceProvider;

class VisitorProvider extends ServiceProvider
{
    /**
     * Bootstrap services
     * @return void
     */
    public function boot(): void
    {
        $visitor = Visitor::updateOrCreateNewVisitor();

        if ($visitor->isBanned()) {
            die($visitor->ban->message);
        }

        // If visitor doesn't have a cookie it will set it
        if (!request()->cookie('rotsiv')) {
            \Cookie::queue('rotsiv', Visitor::whereIp(request()->ip())->value('id'), 218400);
        }
    }
}
