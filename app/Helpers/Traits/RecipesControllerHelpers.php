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
            $image_name = set_image_name($extention);

            // Big image
            Image::make($image)
                ->resize(600, 400)
                ->insert(storage_path('app/public/other/watermark.png'))
                ->save(storage_path("app/public/images/$image_name"));

            // Small image
            Image::make($image)
                ->resize(240, 160)
                ->save(storage_path("app/public/images/small/$image_name"));

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
            Storage::delete([
                "public/images/$image",
                "public/images/small/$image",
            ]);
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

            'title_' . lang() => $request->title,
            'intro_' . lang() => $request->intro,
            'text_' . lang() => $request->text,
            'ingredients_' . lang() => $request->ingredients,
            'simple' => $this->isSimple($request),
            'ready_' . lang() => ($request->ready == 1) ? 1 : 0,
            'approved_' . lang() => ($request->ready == 1 && user()->isAdmin()) ? 1 : 0,
        ];

        // If recipe is not new, if it is an existing recipe
        if ($recipe) {
            // If recipe moved from being ready to not ready
            if ($recipe->isReady() && $request->ready == 0) {
                event(new \App\Events\RecipeGotDrafted($recipe));
                cache()->forget('popular_recipes');
                cache()->forget('random_recipes');
                cache()->forget('all_unapproved');
                cache()->forget('search_suggest');
            }
            $recipe->categories()->sync($request->categories);
            return $recipe->update($recipe_columns);
        }

        // Create recipe coz $recipe is null
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
                $user_id = user()->id;
                $user_name = user()->name;

                logger()->emergency("User with name $user_name and id $user_id was trying to inject javascript script tags in his recipe. User data:" . user());

                Notification::sendToAdmin(
                    'title_script_attack',
                    'message_script_attack',
                    "user_id:  $user_id, user_name: $user_name"
                );
                cache()->forget('admin_notifs');
            }
        }
    }

    /**
     * @return boolean
     */
    public function isSimple($request): bool
    {
        $ingredients = count(convert_to_array_of_list_items($request->ingredients));
        $text = count(convert_to_array_of_list_items($request->text));

        return $ingredients + $text <= 10 ? true : false;
    }
}
