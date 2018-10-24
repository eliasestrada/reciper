<?php

namespace App\Helpers\Traits;

use App\Models\User;
use File;
use Illuminate\Http\UploadedFile;
use Image;

trait PhotoControllerHelpers
{
    /**
     * @param UploadedFile|null $image
     * @return string|null
     */
    public function saveImageIfExist(?UploadedFile $image = null): ?string
    {
        if (is_null($image)) {
            return null;
        }

        $path_slug = $this->makePathSlug();
        $path = storage_path("app/public/users/$path_slug");
        $path_small = storage_path("app/public/small/users/$path_slug");
        $image_name = set_image_name($image->getClientOriginalExtension());

        if (!File::exists($path) && !File::exists($path_small)) {
            File::makeDirectory($path, 0777, true);
            File::makeDirectory($path_small, 0777, true);
        }

        Image::make($image)
            ->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            }, 'top')
            ->save("$path/$image_name");

        Image::make($image)
            ->fit(60, 60, function ($constraint) {
                $constraint->upsize();
            }, 'top')
            ->save("$path_small/$image_name");

        return "$path_slug/$image_name";
    }

    /**
     * @param string|null $file_name
     * @return void
     */
    public function updateImageInDatabase(?string $file_name = null): void
    {
        user()->update([
            'image' => is_null($file_name) ? 'default.jpg' : $file_name,
        ]);
    }

    /**
     * Function helper
     * @return string
     */
    public function makePathSlug(): string
    {
        return date('Y') . '/' . date('n');
    }
}
