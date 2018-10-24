<?php

namespace App\Helpers\Traits;

use App\Models\User;
use File;
use Illuminate\Http\UploadedFile;
use Image;

trait PhotoControllerHelpers
{
    /**
     * @param UploadedFile|null $photo
     * @return string|null
     */
    public function savePhotoIfExist(?UploadedFile $photo = null): ?string
    {
        if (is_null($photo)) {
            return null;
        }

        $path_slug = $this->makePathSlug();
        $path = storage_path("app/public/users/$path_slug");
        $path_small = storage_path("app/public/small/users/$path_slug");
        $photo_name = set_image_name($photo->getClientOriginalExtension());

        if (!File::exists($path) && !File::exists($path_small)) {
            File::makeDirectory($path, 0777, true);
            File::makeDirectory($path_small, 0777, true);
        }

        Image::make($photo)
            ->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            }, 'top')
            ->save("$path/$photo_name");

        Image::make($photo)
            ->fit(60, 60, function ($constraint) {
                $constraint->upsize();
            }, 'top')
            ->save("$path_small/$photo_name");

        return "$path_slug/$photo_name";
    }

    /**
     * @param string|null $photo_name
     * @return void
     */
    public function updatePhotoInDatabase(?string $photo_name = null): void
    {
        user()->update([
            'photo' => is_null($photo_name) ? 'default.jpg' : $photo_name,
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
