<?php

namespace App\Http\Controllers;

class ArtisanController extends Controller
{
    /**
     * @param string $url_key
     * @return void
     */
    public function cache($url_key): void
    {
        if ($url_key != config('custom.url_key')) {
            abort(403);
        }
        try {
            \Artisan::call('config:cache');
            \Artisan::call('route:cache');

            logger()->info("Artisan commands 'config:cache' and 'route:cache' has been fired");

            echo trans('messages.cache_saved') . '<br>';
            echo '<a href="/" title="' . trans('home.home') . '">' . trans('home.home') . '</a>';
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param string $url_key
     * @return void
     */
    public function clear($url_key): void
    {
        if ($url_key != config('custom.url_key')) {
            abort(403);
        }
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            \Artisan::call('route:clear');

            logger()->info("Artisan commands 'cache:clear', 'config:clear', 'view:clear' and 'route:clear' has been fired");

            echo trans('messages.cache_deleted') . '<br>';
            echo '<a href="/" title="' . trans('home.home') . '">' . trans('home.home') . '</a>';
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
