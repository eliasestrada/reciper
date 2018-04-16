<?php

namespace App\Http\Controllers;

use Image;
use App\User;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SettingsPhotoRequest;
use App\Http\Requests\SettingsUpdateUserDataRequest;
use App\Http\Requests\SettingsUpdateUserPasswordRequest;

class SettingsController extends Controller
{
	public function __construct()
    {
        $this->middleware('author');
	}

	/**
	 * Update photo
	 * 
	 * @param SettingsPhotoRequest $request
	 */
	public function updatePhoto(SettingsPhotoRequest $request)
    {
		
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

	/**
	 * Update User data
	 * 
	 * @param SettingsUpdateUserDataRequest $request
	 */
	public function updateUserData(SettingsUpdateUserDataRequest $request)
	{
		$user = User::find(auth()->user()->id);
		$user->name = $request->name;
		$user->save();

		return back()->with(
			'success', 'Настройки сохранены'
		);
	}

	/**
	 * UPDATE USER PASSWORD
	 * 
	 * @param SettingsUpdateUserPasswordRequest $request
	 */
	public function updateUserPassword(SettingsUpdateUserPasswordRequest $request)
	{
		$current_password = auth()->user()->password;

        if(Hash::check($request->old_password, $current_password)) {
			$user = User::find(auth()->user()->id);
			$user->password = Hash::make($request->password);
			$user->save();

			return back()->with(
				'success', 'Настройки сохранены'
			);
        } else {           
			return back()->with(
				'error', 'Неверный пароль'
			);
        }
	}

	/**
	 * TITLES
	 */
	public function titles()
	{
		$title_banner = Title::whereName('Баннер')
				->first(['title', 'text']);

		$title_intro = Title::whereName('Интро')
				->first(['title', 'text']);

		return view('settings.titles')->with([
			'title_banner' => $title_banner,
			'title_intro' => $title_intro
		]);
	}

	/**
	 * UPDATE BANNER
	 */
	public function updateBannerData(Request $request)
	{
		$this->validate($request,
			['title' => 'max:190'],
			['title.max' => 'Заголовок должен быть не более 190 символов']
		);

		$banner = Title::whereName('Баннер')->update([
			'title' => $request->title,
			'text' => $request->text
		]);

		return back()->with(
			'success', 'Настройки баннера сохранены'
		);
	}

	/**
	 * UPDATE INTRO
	 * 
	 * @param Request $request
	 */
	public function updateIntroData(Request $request)
	{
		$this->validate($request,
			['title' => 'max:190'],
			['title.max' => 'Заголовок должен быть не более 190 символов']
		);

		$banner = Title::whereName('Интро')->update([
			'title' => $request->title,
			'text' => $request->text
		]);

		return back()->with(
			'success', 'Настройки интро главной страницы сохранены'
		);
	}

	/**
	 * UPDATE FOOTER
	 * 
	 * @param Request $request
	 */
	public function updateFooterData(Request $request)
	{
		$banner = Title::whereName('Подвал')->update([
			'text' => $request->text
		]);

		return back()->with(
			'success', 'Настройки подвала сохранены'
		);
	}
}