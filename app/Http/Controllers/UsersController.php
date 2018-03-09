<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use Image;

class UsersController extends Controller
{
    // INDEX
    public function index() {
		$users = DB::table('users')->paginate(30);

        return view('users.index')->withUsers($users);
	}

    // SHOW
	public function show($id)
    {
		$user = User::find($id);

		$recipes = DB::table('recipes')
				->where('user_id', $user->id)
				->latest()
				->paginate(20);

		return view('users.show')
				->withRecipes($recipes)
				->withUser($user);
	}

	// EDIT
    public function edit()
    {
		$user = auth()->user();

		return view('users.edit')
				->withUser($user);
    }

    public function update(Request $request)
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
		
		return redirect('/edit')
                    ->with('success', 'Настройки сохранены');
    }
}
