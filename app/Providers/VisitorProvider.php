<?php

namespace App\Providers;

use Schema;
use App\Models\Visitor;
use Illuminate\Support\ServiceProvider;

class VisitorProvider extends ServiceProvider
{
    // Bootstrap services
    public function boot()
    {
		$this->visitorVisitsTheSite();
	}


	public function visitorVisitsTheSite()
	{
		if (Schema::hasTable('visitors')) {
			Visitor::incrementRequestsOrCreate();
		} else {
			logger()->emergency("Table visitors wasn't found while trying to increment requests of the visitor or create new visitor, name of the method: visitorVisitsTheSite");
		}
	}
}
