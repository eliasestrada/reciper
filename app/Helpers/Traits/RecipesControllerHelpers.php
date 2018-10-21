<?php

namespace App\Helpers\Traits;

use App\Models\User;
use App\Notifications\ScriptAttackNotification;

trait RecipesControllerHelpers
{
    /**
     * @return string
     * @param string $image
     */
    public function saveImageIfExists($image): ?string
    {
        if ($image) {
            $image_name = set_image_name($image->getClientOriginalExtension());

            // Big image
            \Image::make($image)
                ->fit(600, 400, function ($constraint) {
                    $constraint->upsize();
                }, 'top')
                ->insert(storage_path('app/public/other/watermark.png'))
                ->save(storage_path("app/public/recipes/$image_name"));

            // Small image
            \Image::make($image)
                ->fit(240, 160, function ($constraint) {
                    $constraint->upsize();
                }, 'top')
                ->save(storage_path("app/public/small/recipes/$image_name"));

            return $image_name;
        }
        return null;
    }

    /**
     * @param string $image
     * @return void
     */
    public function deleteOldImage($image): void
    {
        if ($image != 'default.jpg') {
            \Storage::delete([
                "public/recipes/$image",
                "public/recipes/small/$image",
            ]);
        }
    }

    /**
     * @param object $request
     * @return object
     */
    public function createRecipe($request)
    {
        return user()->recipes()->create(['title_' . LANG() => $request->title]);
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
        $ingredients = count(convert_to_array_of_list_items($request->ingredients));
        $text = count(convert_to_array_of_list_items($request->text));

        return $ingredients + $text <= 10 ? ($request->time < 60 ? true : false) : false;
    }
}
