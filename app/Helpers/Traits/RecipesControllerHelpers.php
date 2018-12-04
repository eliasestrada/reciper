<?php

namespace App\Helpers\Traits;

use App\Models\User;
use App\Notifications\ScriptAttackNotification;
use File;
use Illuminate\Http\UploadedFile;
use Image;

trait RecipesControllerHelpers
{
    /**
     * @param \Illuminate\Http\UploadedFile|null $image
     * @param string $slug
     * @return string
     */
    public function saveImageIfExist(?UploadedFile $image = null, string $slug): ?string
    {
        if (is_null($image)) {
            return null;
        }

        $path_slug = $this->makePathSlug();
        $path = storage_path("app/public/big/recipes/{$path_slug}");
        $path_small = storage_path("app/public/small/recipes/{$path_slug}");
        $image_name = "{$slug}.{$image->getClientOriginalExtension()}";

        $this->makeNeededDerectoriesFor([$path, $path_small]);

        $this->uploadImages($image, $image_name, [
            [
                'path' => $path,
                'width' => 600,
                'height' => 400,
                'watermark' => true,
            ],
            [
                'path' => $path_small,
                'width' => 240,
                'height' => 160,
                'watermark' => false,
            ],
        ]);

        return "$path_slug/$image_name";
    }

    /**
     * @param object $request
     * @return object
     */
    public function createRecipe($request)
    {
        return user()->recipes()->create([
            'title_' . LANG() => $request->title,
            'slug' => str_slug($request->title) . '-' . time(),
        ]);
    }

    /**
     * @param object $request
     * @param string $image_name
     * @param oblect $recipe
     * @return object
     */
    public function updateRecipe($request, $image_name, $recipe)
    {
        $recipe_columns = [
            'image' => $image_name ? $image_name : $recipe->image ?? 'default.jpg',
            'meal_id' => request('meal', 0),
            'time' => request('time', 0),

            'title_' . LANG() => $request->title,
            'intro_' . LANG() => $request->intro,
            'text_' . LANG() => $request->text,
            'ingredients_' . LANG() => $request->ingredients,
            'simple' => $this->isSimple($request),
            'ready_' . LANG() => ($request->ready == 1) ? 1 : 0,
            'approved_' . LANG() => ($request->ready == 1 && user()->hasRole('admin')) ? 1 : 0,
        ];

        // If recipe moved from being ready to not ready
        if ($recipe->isReady() && $request->ready == 0) {
            event(new \App\Events\RecipeGotDrafted($recipe));
        }

        $recipe->categories()->sync($request->categories);

        return $recipe->update($recipe_columns);
    }

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
     * @return boolean
     */
    public function isSimple($request): bool
    {
        $ingredients = count(to_array_of_list_items($request->ingredients));
        $text = count(to_array_of_list_items($request->text));

        $allowed_maximum_of_rows = config('custom.rows_for_simple_recipe');
        $sum = $ingredients + $text;

        if ($request->ingredients == '' || $request->text == '') {
            return false;
        }

        if ($sum <= $allowed_maximum_of_rows && $request->time < 60) {
            return true;
        }

        return false;
    }

    /**
     * Function helper
     * @return string
     */
    public function makePathSlug(): string
    {
        return date('Y') . '/' . date('n');
    }

    /**
     * @param array $paths
     * @return void
     */
    public function makeNeededDerectoriesFor(array $paths): void
    {
        foreach ($paths as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true);
            }
        }
    }

    /**
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $image_name
     * @param array $image_data
     * @return void
     */
    public function uploadImages(UploadedFile $image, string $image_name, array $image_data): void
    {
        foreach ($image_data as $data) {
            $image_inst = Image::make($image);

            $image_inst->fit($data['width'], $data['height'], function ($constraint) {
                $constraint->upsize();
            }, 'top');

            if ($data['watermark']) {
                $image_inst->insert(storage_path('app/public/other/watermark.png'));
            }

            $image_inst->save("{$data['path']}/{$image_name}");
        }
    }
}
