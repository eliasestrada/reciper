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
    public function boot() : void
    {
		$this->visitorVisitsTheSite();
	}

	/**
     * @return void
     */
	public function visitorVisitsTheSite() : void
	{
		Visitor::incrementRequestsOrCreate();
	}
}
