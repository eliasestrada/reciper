<?php

namespace App\Http\Controllers;

use Artisan;


class ArtisanController extends Controller
{
	
	public function cache($url_key)
	{
        if ($url_key != config('custom.url_key')) {
            abort( 403 );
		}
        try {
            Artisan::call('config:cache');
			Artisan::call('route:cache');

			logger()->info("Artisan commands 'config:cache' and 'route:cache' has been fired");

            echo 'Настройки кеша сохранены! <br> <a href="/" title="На главную">На главную</a>';

        } catch (Exception $e) {
            die( $e->getMessage() );
        }
	}
	

	public function clear($url_key)
	{
        if ($url_key != config('custom.url_key')) {
            abort( 403 );
		}
        try {
			Artisan::call('cache:clear');
			Artisan::call('config:clear');
			Artisan::call('view:clear');
			Artisan::call('route:clear');

			logger()->info("Artisan commands 'cache:clear', 'config:clear', 'view:clear' and 'route:clear' has been fired");

            echo 'Настройки кеша удалены! <br> <a href="/" title="На главную">На главную</a>';
        } catch (Exception $e) {
            die( $e->getMessage() );
        }
	}
}
