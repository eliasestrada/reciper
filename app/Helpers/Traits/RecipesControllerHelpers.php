<?php

namespace App\Helpers\Traits;

use App\Models\Notification;
use Image;
use Storage;

trait RecipesControllerHelpers
{
    /**
     * @return string
     * @param string $image
     */
    public function saveImageIfExists($image): ?string
    {
        if ($image) {
            $extention = $image->getClientOriginalExtension();
            $image_name = setImageName($extention);

            Image::make($image)->resize(600, 400)->save(
                storage_path('app/public/images/' . $image_name
                ));
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
            Storage::delete('public/images/' . $image);
        }
    }

    /**
     * @param object $request
     * @param string $image_name
     * @param oblect|null $recipe
     * @return object
     */
    public function createOrUpdateRecipe($request, $image_name, $recipe = null)
    {
        $recipe_columns = [
            'image' => $image_name ? $image_name : $recipe->image ?? 'default.jpg',
            'meal_id' => $request->meal,
            'time' => $request->time,

            'title_' . locale() => $request->title,
            'intro_' . locale() => $request->intro,
            'text_' . locale() => $request->text,
            'ingredients_' . locale() => $request->ingredients,
            'ready_' . locale() => isset($request->ready) ? 1 : 0,
            'approved_' . locale() => user()->isAdmin() ? 1 : 0,
        ];

        if ($recipe) {
            $recipe->categories()->sync($request->categories);
            return $recipe->update($recipe_columns);
        }

        $create = user()->recipes()->create($recipe_columns);
        $create->categories()->sync($request->categories);

        return $create;
    }

    /**
     * @param object $request
     * @return void
     */
    public function checkForScriptTags($request): void
    {
        foreach ($request->all() as $field) {
            if (is_string($field) && preg_match("/<script>/", $field)) {

                logger()->emergency('User with name "' . user()->name . '" and id "' . user()->id . '" was trying to inject javascript script tags in his recipe. User data: ' . user());

                Notification::sendMessage(
                    'notifications.title_script_attack',
                    'notifications.message_script_attack',
                    'user_id: ' . user()->id . ', user_name: ' . user()->name,
                    null, 1, 1);
            }
        }
    }
}
