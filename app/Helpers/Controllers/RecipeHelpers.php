<?php

namespace App\Helpers\Controllers;

use Predis\Connection\ConnectionException;
use Illuminate\Http\Request;
use App\Notifications\ScriptAttackNotification;
use App\Models\User;
use App\Jobs\DeleteFileJob;
use Illuminate\Database\QueryException;

trait RecipeHelpers
{
    /**
     * Loops through given array and looks for
     * javascript script tag
     *
     * @param array $fields (All fields from request except _method and _token)
     * @param \App\Models\User $user (optional for unit testing)
     * @return boolean
     */
    public function checkForScriptTags(array $fields, ?User $user = null): bool
    {
        $user = $user ?? user();

        $string_fields = array_filter($fields, function ($field) {
            return is_string($field) && mb_strlen($field) > 2;
        });

        $dangerous_fields = array_filter($string_fields, function ($field) {
            return preg_match("/<script/", $field);
        });

        if (empty($dangerous_fields)) {
            return false;
        }

        logger()->emergency("User was trying to inject javascript script tags in his recipe. User data: {$user}");

        try {
            User::whereId(1)->first()->notify(new ScriptAttackNotification($user->username));
        } catch (QueryException $e) {
            logger()->error("Can't send ScriptAttackNotification to a user. {$e->getMessage()}");
        }
        return true;
    }

    /**
     * @param string $filename
     * @return void
     */
    public function dispatchDeleteFileJob(string $filename): void
    {
        if ($filename != 'default.jpg') {
            try {
                DeleteFileJob::dispatch([
                    "public/big/recipes/{$filename}",
                    "public/small/recipes/{$filename}",
                ]);
            } catch (ConnectionException $e) {
                logger()->error("DeleteFileJob was not dispatched. {$e->getMessage()}");
            }
        }
    }

    /**
     * @return void
     */
    protected function clearCache(): void
    {
        cache()->forget('popular_recipes');
        cache()->forget('random_recipes');
        cache()->forget('unapproved_notif');
    }
}
