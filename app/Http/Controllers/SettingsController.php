<?php

namespace App\Http\Controllers;

use Hash;
use Image;
use Storage;
use App\Models\User;
use App\Models\Title;
use Illuminate\Http\Request;
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
		return view('settings.photo');
	}


	public function updatePhoto(SettingsPhotoRequest $request)
    {
		
		$user = User::find(user()->id);

		if ($request->hasFile('image')) {
			$image = $request->file('image');

			$filename = 'user' . user()->id . '.' . $image->getClientOriginalExtension();
			
			Image::make($image)->resize(300, 300)->save(storage_path('app/public/uploads/' . $filename ));
			
            $user->image = $filename;
		} elseif ($request->delete == 1) {
			if ($request->hasFile('image') != 'default.jpg') {
				Storage::delete('public/uploads/'.$user->image);
				$user->image = 'default.jpg';
			}
		}
		$user->save();
		
		return redirect('/settings/photo')->withSuccess(
			trans('settings.saved')
		);
	}


	public function updateUserData(SettingsUpdateUserDataRequest $request)
	{
		user()->update([ 'name' => $request->name ]);
		return back()->withSuccess(trans('settings.saved'));
	}


	public function updateUserPassword(SettingsUpdateUserPasswordRequest $request)
	{
        if (Hash::check($request->old_password, user()->password)) {
			user()->update([
				'password' => Hash::make($request->password)
			]);

			return back()->withSuccess(trans('settings.saved'));
        } else {           
			return back()->withError(trans('settings.pwd_wrong'));
        }
	}


	public function updateIntroData(SettingsUpdateHomeDataRequest $request)
	{
		Title::whereName('intro')->update([
			'title_' . locale() => $request->title,
			'text_' . locale() => $request->text
		]);

		return back()->withSuccess(
			trans('settings.saved')
		);
	}


	public function updateFooterData(Request $request)
	{
		$data = $this->validate($request,
			['text'     => 'max:190'],
			['text.max' => trans('settings.footer_text_max')]
		);

		Title::whereName('footer')->update([
			'text_' . locale() => $request->text
		]);

		return back()->withSuccess(
			trans('settings.saved')
		);
	}
}
