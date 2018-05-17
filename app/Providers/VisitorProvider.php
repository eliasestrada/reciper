<?php

namespace App\Providers;

use App\Models\Visitor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class VisitorProvider extends ServiceProvider
{
    // Bootstrap services
    public function boot()
    {
		if (Schema::hasTable('visitors')) {
			Visitor::firstOrCreateNewVisitor();
		}
    }
}
