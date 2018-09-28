<?php

namespace App\Helpers\Traits;

use App\Models\Notification;

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
                ->save(storage_path("app/public/images/$image_name"));

            // Small image
            \Image::make($image)
                ->fit(240, 160, function ($constraint) {
                    $constraint->upsize();
                }, 'top')
                ->save(storage_path("app/public/images/small/$image_name"));

            // Tiny image
            \Image::make($image)
                ->fit(50, 30, function ($constraint) {
                    $constraint->upsize();
                }, 'top')
                ->save(storage_path("app/public/images/tiny/$image_name"));

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
                "public/images/$image",
                "public/images/small/$image",
                "public/images/tiny/$image",
            ]);
        }
    }

    /**
     * @param object $request
     * @return object
     */
    public function createRecipe($request)
    {
        return user()->recipes()->create(['title_' . lang() => $request->title]);
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
            'meal_id' => $request->meal ?? 0,
            'time' => $request->time ?? 0,

            'title_' . lang() => $request->title,
            'intro_' . lang() => $request->intro,
            'text_' . lang() => $request->text,
            'ingredients_' . lang() => $request->ingredients,
            'simple' => $this->isSimple($request),
            'ready_' . lang() => ($request->ready == 1) ? 1 : 0,
            'approved_' . lang() => ($request->ready == 1 && user()->hasRole('admin')) ? 1 : 0,
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
                    trans('notifications.title_script_attack'),
                    trans('notifications.message_script_attack'),
                    "user_id:  $user_id, user_name: $user_name"
                );
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
