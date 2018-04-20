<?php

namespace App\Http\Controllers;

use Image;
use App\User;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SettingsPhotoRequest;
use App\Http\Requests\SettingsUpdateHomeDataRequest;
use App\Http\Requests\SettingsUpdateUserDataRequest;
use App\Http\Requests\SettingsUpdateUserPasswordRequest;

class SettingsController extends Controller
{

	public function __construct()
    {
		$this->middleware('author');
	}

	public function general()
	{
		return view('settings.general');
	}

	public function photo()
	{
		return view('settings.photo')->withUser(auth()->user());
	}


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
		
		return redirect('/settings/photo')->withSuccess('Настройки сохранены');
	}


	public function updateUserData(SettingsUpdateUserDataRequest $request)
	{
		auth()->user()->update([
			'name' => $request->name
		]);

		return back()->withSuccess('Настройки сохранены');
	}


	public function updateUserPassword(SettingsUpdateUserPasswordRequest $request)
	{
		$user = auth()->user();

        if(Hash::check($request->old_password, $user->password)) {
			$user->update([
				'password' => Hash::make($request->password)
			]);

			return back()->withSuccess('Настройки сохранены');
        } else {           
			return back()->withError('Неверный пароль');
        }
	}

	
	public function titles()
	{
		$title_banner = Title::whereName('Баннер')->first(['title', 'text']);
		$title_intro = Title::whereName('Интро')->first(['title', 'text']);

		return view('settings.titles')->with([
			'title_banner' => $title_banner,
			'title_intro'  => $title_intro
		]);
	}

	public function updateBannerData(SettingsUpdateHomeDataRequest $request)
	{
		Title::whereName('Баннер')->update([
			'title' => $request->title,
			'text'  => $request->text
		]);

		return back()->withSuccess('Настройки баннера сохранены');
	}


	public function updateIntroData(SettingsUpdateHomeDataRequest $request)
	{
		Title::whereName('Интро')->update([
			'title' => $request->title,
			'text'  => $request->text
		]);

		return back()->withSuccess(
			'Настройки интро главной страницы сохранены'
		);
	}


	public function updateFooterData(Request $request)
	{
		$data = $this->validate($request,
			[ 'text'     => 'max:190' ],
			[ 'text.max' => 'Текст не должен быть не более 190 символов' ]
		);
		
		Title::whereName('Подвал')->update($data);

		return back()->withSuccess(
			'Настройки подвала сохранены'
		);
	}
}
