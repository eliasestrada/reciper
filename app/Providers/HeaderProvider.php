<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HeaderProvider extends ServiceProvider
{
	protected $https = false;
    /**
     * Bootstrap services
     * @return void
     */
    public function boot()
    {
		$sts_dirs = ["max-age=31536000"];

		$headers = [
			'Strict-Transport-Security: ' . implode("; ", $sts_dirs),
		];

		foreach ($headers as $header) {
			header($header);
		}
    }
}
