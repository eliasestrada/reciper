<?php

namespace App\Http\Controllers\Invokes;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteFileJob;
use App\Models\Recipe;
use Illuminate\Http\Request;
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
        $filename = 'ingredients-' . date('d-m-Y H-i-s') . '.txt';

        Storage::put($filename, $text);
        DeleteFileJob::dispatch($filename)->delay(now()->addSeconds(7));

        return response()->download(storage_path("app/{$filename}"));
    }
}
