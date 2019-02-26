<?php

namespace App\Http\Responses\Controllers\Recipes;

use Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use File;
use App\Helpers\Controllers\RecipeHelpers;

class UpdateResponse implements Responsable
{
    use RecipeHelpers;

    /**
     * @var \App\Models\Recipe $recipe
     */
    private $recipe;

    /**
     * @var string $filename
     */
    private $filename;

    /**
     * @param string $slug
     * @param \App\Repos\RecipeRepo $recipe_repo
     * @return void
     */
    public function __construct(string $slug, $recipe_repo)
    {
        $this->recipe = $recipe_repo->find($slug);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        if (!user()->hasRecipe($this->recipe->id)) {
            return back()->withError(trans('recipes.cant_draft'));
        }

        if ($this->recipe->isReady()) {
            return $this->moveToDraftsAndRedirectWithSuccess();
        }

        if ($this->checkForScriptTags($request->except(['_method', '_token']))) {
            return back()->withError(trans('notifications.cant_use_script_tags'));
        }

        if ($request->file('image')) {
            $this->dispatchDeleteFileJob($this->recipe->image);
        }

        $this->filename = $this->saveImageIfExist($request->file('image'), $this->recipe->slug);
        $this->updateRecipe($request);

        if ($this->recipe->isReady() && user()->hasRole('admin')) {
            return $this->fireEventAndRedirectWithSuccess();
        }

        if ($this->recipe->isReady()) {
            cache()->forget('unapproved_notif');
            return $this->redirectWithSuccess();
        }

        if (request()->has('view')) {
            return redirect("/recipes/{$this->recipe->slug}");
        }

        return redirect("/recipes/{$this->recipe->slug}/edit")
            ->withSuccess(trans('recipes.saved'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fireEventAndRedirectWithSuccess(): RedirectResponse
    {
        event(new \App\Events\RecipeGotApproved($this->recipe));

        return redirect('/users/other/my-recipes')
            ->withSuccess(trans('recipes.recipe_published'));
    }

    /**
     * @codeCoverageIgnore
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWithSuccess(): RedirectResponse
    {
        return redirect('/users/other/my-recipes')
            ->withSuccess(trans('recipes.added_to_approving'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function moveToDraftsAndRedirectWithSuccess(): RedirectResponse
    {
        $this->recipe->moveToDrafts();
        $this->clearCache();

        return redirect("/recipes/{$this->recipe->slug}/edit")
            ->withSuccess(trans('recipes.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function updateRecipe(Request $request): bool
    {
        $recipe_columns = [
            'image' => $this->filename ? $this->filename : $this->recipe->image ?? 'default.jpg',
            'meal_id' => request('meal', 0),
            'time' => request('time', 0),

            _('title') => $request->title,
            _('intro') => $request->intro,
            _('text') => $request->text,
            _('ingredients') => $request->ingredients,
            'simple' => $this->isSimple($request),
            _('ready') => ($request->ready == 1) ? 1 : 0,
            _('approved') => ($request->ready == 1 && user()->hasRole('admin')) ? 1 : 0,
        ];

        // If recipe moved from being ready to not ready
        if ($this->recipe->isReady() && $request->ready == 0) {
            event(new \App\Events\RecipeGotDrafted($this->recipe));
        }

        $this->recipe->categories()->sync($request->categories);

        return $this->recipe->update($recipe_columns);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function isSimple(Request $request): bool
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

        $this->makeNeededDirectoriesFor([$path, $path_small]);

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
    public function makeNeededDirectoriesFor(array $paths): void
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
