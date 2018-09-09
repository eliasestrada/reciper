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
        Visitor::incrementRequestsOrCreate();

        // If visitor doesn't have a cookie it will set it
        if (!request()->cookie('visitor_id')) {
            \Cookie::queue('visitor', Visitor::whereIp(request()->ip())->value('id'), 218400);
        }
    }
}
