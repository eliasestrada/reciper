<?php

namespace App\Http\Controllers\Invokes;

use Storage;
use Predis\Connection\ConnectionException;
use App\Models\Recipe;
use App\Jobs\DeleteFileJob;
use App\Http\Controllers\Controller;

class DownloadIngredientsController extends Controller
{
    /**
     * Creates file with list of ingredients, downloads it to user and
     * puts DeleteFileJob on queue
     *
     * @param int $recipe_id
     */
    public function __invoke(int $recipe_id)
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
