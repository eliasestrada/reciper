<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use Image;

class SettingsController extends Controller
{
	public function __construct()
    {
        $this->middleware('author');
	}

	// INDEX
    public function index() {
		return view('settings.index');
	}

    // EDIT PHOTO
    public function editPhoto()
    {
		$user = auth()->user();

		return view('settings.photo')
				->withUser($user);
	}

	// UPADE PHOTO
	public function updatePhoto(Request $request)
    {
        $this->validate($request, [
            'изображение' => 'image|nullable|max:1999'
		]);
		
		$user = User::find(auth()->user()->id);

		if ($request->hasFile('изображение')) {
			$image = $request->file('изображение');

			$filename = 'user' . auth()->user()->id . '.' . $image->getClientOriginalExtension();
			
			Image::make($image)->resize(300, 300)->save(storage_path('app/public/uploads/' . $filename ));
			
            $user->image = $filename;
		} elseif ($request->delete == 1) {
			if ($request->hasFile('изображение') != 'default.jpg') {
				Storage::delete('public/uploads/'.$user->image);
				$user->image = 'default.jpg';
			}
		}
		$user->save();
		
		return redirect('/settings/photo')
                    ->with('success', 'Настройки сохранены');
    }
}
