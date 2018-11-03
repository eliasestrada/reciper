<?php

namespace App\Http\Controllers\Invokes;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFileJob;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Predis\Connection\ConnectionException;
use Storage;

class DownloadIngredientsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param int $recipe_id
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request, int $recipe_id)
    {
        $recipe = Recipe::find($recipe_id);
        $text = $recipe->getTitle() . PHP_EOL . PHP_EOL . $recipe->getIngredients();
        $filename = 'ingredients-' . date('d-m-Y H-i') . '.txt';

        Storage::put($filename, $text);

        try {
            DeleteFileJob::dispatch($filename)->delay(now()->addSeconds(7));
        } catch (ConnectionException $e) {
            logger()->error("DeleteFileJob wasn't executed. {$e->getMessage()}");
        }

        return response()->download(storage_path("app/{$filename}"));
    }
}
