<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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

	// Update photo
	public function updatePhoto(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|nullable|max:1999'
		], [
            'image.image' => 'Файл не является изображением',
			'image.max' => 'Изображение не должно превышать :max Кбайт',
			'image.uploaded' => 'Загрузка не удалась, возможно это связано с большим разширением, изображение не должно превышать 1999 Кбайт'
        ]);
		
		$user = User::find(auth()->user()->id);

		if ($request->hasFile('image')) {
			$image = $request->file('image');

			$filename = 'user' . auth()->user()->id . '.' . $image->getClientOriginalExtension();
			
			Image::make($image)->resize(300, 300)->save(storage_path('app/public/uploads/' . $filename ));
			
            $user->image = $filename;
		} elseif ($request->delete == 1) {
			if ($request->hasFile('image') != 'default.jpg') {
				Storage::delete('public/uploads/'.$user->image);
				$user->image = 'default.jpg';
			}
		}
		$user->save();
		
		return redirect('/settings/photo')
                    ->with('success', 'Настройки сохранены');
	}
	
	// GENERAL
	public function general()
	{
		return view('settings.general');
	}

	// UpdateUserData
	public function updateUserData(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|min:3|max:190'
		], [
            'name.required' => 'Поле имя обязателено к заполнению',
			'name.min' => 'Имя должно быть хотябы 6 символов',
			'name.max' => 'Имя не должно превышать 190 символов'
        ]);

		$user = User::find(auth()->user()->id);
		$user->name = $request->name;
		$user->save();

		return back()->with('success', 'Настройки сохранены');
	}

	// UpdateUserPassword
	public function updateUserPassword(Request $request)
	{
		$this->validate($request, [
			'old_password' => 'required|string',
			'password' => 'required|string|min:6|confirmed'
		], [
            'old_password.required' => 'Старый пароль обязателен к заполнению',
            'password.required' => 'Новый пароль обязателен к заполнению',
            'password.min' => 'Пароль должен иметь хотябы 6 символов',
            'password.confirmed' => 'Пароли не совпадают'
        ]);

		$current_password = auth()->user()->password;
          
        if(Hash::check($request->old_password, $current_password)) {          
			$user = User::find(auth()->user()->id);          
			$user->password = Hash::make($request->password);
			$user->save(); 
			return back()->with('success', 'Настройки сохранены');
        }
        else {           
			return back()->with('error', 'Неверный пароль');
        }
	}
}