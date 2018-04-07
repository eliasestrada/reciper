<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Title;
use App\User;
use Image;

class SettingsController extends Controller
{
	public function __construct()
    {
        $this->middleware('author');
	}

    /* EDIT PHOTO
	====================== */

    public function editPhoto()
    {
		return view('settings.photo')->with(
			'user', auth()->user()
		);
	}

	/* UPDATE PHOTO
	====================== */

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
		
		return redirect('/settings/photo')->with(
			'success', 'Настройки сохранены'
		);
	}
	
	/* GENERAL
	====================== */

	public function general()
	{
		return view('settings.general');
	}

	/* UPDATE USER DATA
	====================== */

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

		return back()->with(
			'success', 'Настройки сохранены'
		);
	}

	/* UPDATE USER PASSWORD
	====================== */

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

			return back()->with(
				'success', 'Настройки сохранены'
			);
        }
        else {           
			return back()->with(
				'error', 'Неверный пароль'
			);
        }
	}

	/* TITLES
	====================== */

	public function titles()
	{
		$title_banner = Title::select(['title', 'text'])
				->where('name', 'Баннер')
				->first();

		$title_intro = Title::select(['title', 'text'])
				->where('name', 'Интро')
				->first();

		return view('settings.titles')->with([
			'title_banner' => $title_banner,
			'title_intro' => $title_intro
		]);
	}

	/* UPDATE BANNER
	====================== */

	public function updateBannerData(Request $request)
	{
		$this->validate($request,
			['title' => 'max:190'],
			['title.max' => 'Заголовок должен быть не более 190 символов']
		);

		$banner = Title::where('name', 'Баннер')->update([
			'title' => $request->title,
			'text' => $request->text
		]);

		return back()->with(
			'success', 'Настройки баннера сохранены'
		);
	}

	/* UPDATE INTRO
	====================== */

	public function updateIntroData(Request $request)
	{
		$this->validate($request,
			['title' => 'max:190'],
			['title.max' => 'Заголовок должен быть не более 190 символов']
		);

		$banner = Title::where('name', 'Интро')->update([
			'title' => $request->title,
			'text' => $request->text
		]);

		return back()->with(
			'success', 'Настройки интро главной страницы сохранены'
		);
	}

	/* UPDATE FOOTER
	====================== */

	public function updateFooterData(Request $request)
	{
		$banner = Title::where('name', 'Подвал')
				->update(['text' => $request->text]);

		return back()->with(
			'success', 'Настройки подвала сохранены'
		);
	}
}