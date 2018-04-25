<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
	
	public function cache($url_key)
	{
        if ($url_key != env('URL_KEY')) {
            abort( 403 );
		}

        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            echo 'Настройки кеша сохранены';

        } catch (Exception $e) {
            die( $e->getMessage() );
        }
	}
	

	public function clear($url_key)
	{
        if ($url_key != env('URL_KEY')) {
            abort( 403 );
		}

        try {
			Artisan::call('cache:clear');
			Artisan::call('config:clear');
			Artisan::call('view:clear');
			Artisan::call('route:clear');
            echo 'Настройки кеша удалены';

        } catch (Exception $e) {
            die( $e->getMessage() );
        }
    }
}
