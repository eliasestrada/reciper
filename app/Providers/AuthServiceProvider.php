<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // The policy mappings for the application
    protected $policies = [
        'App\Models\Document' => 'App\Policies\DocumentPolicy',
    ];

    // register any authentication / authorization services
    public function boot()
    {
        $this->registerPolicies();

        \Gate::resource('documents', 'App\Policies\DocumentPolicy');
    }
}
