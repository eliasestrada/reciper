<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{

    public function boot()
    {
		Blade::if('admin', function() {
			return auth()->check() && user()->isAdmin();
		});

		Blade::if('author', function() {
			return auth()->check() && user()->isAuthor();
		});
    }
}
