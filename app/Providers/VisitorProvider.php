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
        // If visitor doesn't have a cookie it will set it
        if (!request()->cookie('rotsiv')) {
            Visitor::updateOrCreateNewVisitor();
            \Cookie::queue('rotsiv', Visitor::whereIp(request()->ip())->value('id'), 218400);
        }
    }
}
