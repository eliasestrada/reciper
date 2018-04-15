<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
    public function cache($url_key) {
        if ($url_key != env('app.url_key')) {
            abort(403);
		}

        try {
            Artisan::call('config:cache');
            echo 'Настройки кеша сохранены';

        } catch (Exception $e) {
            die($e->getMessage());
        }
	}
	
	public function clear($url_key) {
        if ($url_key != env('app.url_key')) {
            abort(403);
		}

        try {
			Artisan::call('cache:clear');
			Artisan::call('config:clear');
			Artisan::call('view:clear');
            echo 'Настройки кеша удалены';

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
