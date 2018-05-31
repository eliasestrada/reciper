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
		$this->visitorVisitsTheSite();
	}


	public function visitorVisitsTheSite()
	{
		if (Schema::hasTable('visitors')) {
			Visitor::incrementRequestsOrCreateIfNewVisitor();
		} else {
			logger()->emergency(trans('logs.no_table', ['table' => 'visitors']));
		}
	}
}
