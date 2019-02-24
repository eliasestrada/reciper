<?php

namespace App\Helpers\Controllers;

use Predis\Connection\ConnectionException;
use App\Notifications\ScriptAttackNotification;
use App\Models\User;
use App\Jobs\DeleteFileJob;

trait RecipeHelpers
{
    /**
     * @param object $request
     * @return boolean
     */
    public function checkForScriptTags($request): bool
    {
        foreach ($request->except(['_method', '_token']) as $field) {
            if (is_string($field) && preg_match("/<script>/", $field)) {
                logger()->emergency('User ' . user()->username . ' with id of ' . user()->id . ' was trying to inject javascript script tags in his recipe. User data:' . user());

                User::whereId(1)->first()->notify(new ScriptAttackNotification(user()->username));
                return true;
            }
        }
        return false;
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
