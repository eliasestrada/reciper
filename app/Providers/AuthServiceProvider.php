<?php

namespace App\Providers;

use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // The policy mappings for the application
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    // egister any authentication / authorization services
    public function boot()
    {
        $this->registerPolicies();
    }
}
