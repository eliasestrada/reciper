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
			logger()->emergency(trans('logs.no_table', ['table' => 'visitors']));
		}
	}
}
