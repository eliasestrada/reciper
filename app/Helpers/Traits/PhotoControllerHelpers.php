<?php

namespace App\Helpers\Traits;

use App\Models\User;
use File;
use Illuminate\Http\UploadedFile;
use Image;
use Storage;

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

        $path_slug = date('Y') . '/' . date('n');
        $path = storage_path("app/public/users/$path_slug");
        $path_small = storage_path("app/public/small/users/$path_slug");
        $image_name = set_image_name($image->getClientOriginalExtension(), 'user' . user()->id);

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

        return $image_name;
    }

    /**
     * @param string $file_name
     * @return void
     */
    public function saveFileNameToDB($file_name = ''): void
    {
        $path_slug = date('Y') . '/' . date('n');
        $user = User::find(user()->id);

        if (empty($file_name)) {
            $user->image = 'default.jpg';
        } else {
            $user->image = "$path_slug/$file_name";
        }
        $user->save();
    }

    /**
     * @param string $file
     * @param string $foder
     * @return void
     */
    public function deleteOldImage(string $file, string $folder): void
    {
        if ($file !== 'default.jpg') {
            Storage::delete("public/$folder/$file");
            Storage::delete("public/small/$folder/$file");
        }
    }
}
