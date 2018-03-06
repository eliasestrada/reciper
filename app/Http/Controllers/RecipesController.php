<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Cookie\CookieJar;

use App\Recipe;
use Image;

class RecipesController extends Controller
{
    // Create a new controller instance.
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
			'index', 'show', 'like', 'dislike'
		]]);
    }

    // INDEX
    public function index()
    {
        $recipes = Recipe::where('approved', 1)->latest()->paginate(30);

        return view('recipes.index')->with('recipes', $recipes);
    }


    // Show the form for creating a new resource.
    public function create()
    {
        // For select input
        $categories = DB::table('categories')->get();

        return view('recipes.create')->with('categories', $categories);
    }

    // STORE
    public function store(Request $request)
    {
		$user = auth()->user();

        $this->validate($request, [
            'название' => 'max:199',
            'описание' => 'max:2000',
            'ингридиенты' => 'max:5000',
            'совет' => 'max:5000',
            'приготовление' => 'max:10000',
            'время' => 'numeric|digits_between:0,1000',
            'изображение' => 'image|nullable|max:1999'
        ]);

        // Create Recipe in DB
        $recipe = new Recipe;
        $recipe->title = $request->input('название');
        $recipe->intro = $request->input('описание');
        $recipe->ingredients = $request->input('ингридиенты');
        $recipe->advice = $request->input('совет');
        $recipe->text = $request->input('приготовление');
        $recipe->time = $request->input('время');
        $recipe->category = $request->input('категория');
        $recipe->user_id = $user->id;
        $recipe->author = $user->name;

        // Handle image uploading
        if ($request->hasFile('изображение')) {
        	$image = $request->file('изображение');
        	$filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(600, 400)->save(storage_path('app/public/images/' . $filename ));
        
        	$recipe->image = $filename;
        } else {
        	$recipe->image = 'default.jpg';
        }

        $recipe->save();

		return redirect('/recipes/'.$recipe->id.'/edit')
				->with('success', 'Рецепт успешно сохранен');
    }

    // SHOW
    public function show($id)
    {
		$user = auth()->user();
		$recipe = Recipe::find($id);

		$random_recipes = Recipe::inRandomOrder()
				->where('approved', 1)
				->limit(5)
				->get();

        if (!$recipe) {
            return redirect('/recipes');
        }

        // Rules for visitors
        if (empty($user->id) && $recipe->approved == 0) {
            return redirect('/recipes')
                    ->with('error', 'У вас нет права просматривать этот рецепт.');
        }

        // Rules for auth users
        if (!empty($user->id)) {
            if ($user->admin !== 1 && $user->id !== $recipe->user_id && $recipe->ready === 0) {
                return redirect('/recipes');
            } elseif ($user->id !== $recipe->user_id && $recipe->approved === 0 && $recipe->ready === 0) {
                return redirect('/recipes')
                        ->with('error', 'Этот рецепт находится в процессе написания.');
            }
        }

		return view('recipes.show')
				->with('recipe', $recipe)
				->with('random_recipes', $random_recipes);
    }

    // EDIT
    public function edit($id)
    {
		$recipe = Recipe::find($id);
		$user = auth()->user();

        // Check for correct user
        if ($user->id !== $recipe->user_id && $user->admin !== 1) {
            return redirect('/recipes')
                    ->with('error', 'Вы не можете редактировать не свои рецепты.');
        }

        if ($recipe->ready == 1 && $user->admin !== 1) {
			return redirect('/recipes')
					->with('error', 'Вы не можете редактировать рецепты которые находятся на рассмотрении или уже опубликованны.');
        }

        // For select input
        $categories = DB::table('categories')->get();

        return view('recipes.edit')
                        ->withRecipe($recipe)
                        ->withCategories($categories);

    }

    // UPDATE
    public function update(Request $request, $id)
    {
		$user = auth()->user();

        // If ready to publish
        if (isset($request->ready)) {
            $this->validate($request, [
                'название' => 'min:5|max:199',
                'описание' => 'min:20|max:2000',
                'ингридиенты' => 'min:20|max:5000',
                'совет' => 'max:5000',
                'приготовление' => 'min:80|max:10000',
                'время' => 'numeric|digits_between:0,1000',
                'изображение' => 'image|nullable|max:1999'
            ]);
        }

        // Create Recipe in DB
        $recipe = Recipe::find($id);
        $recipe->ready = isset($request->ready) ? 1 : 0;
        $recipe->title = $request->input('название');
        $recipe->intro = $request->input('описание');
        $recipe->ingredients = $request->input('ингридиенты');
        $recipe->advice = $request->input('совет');
        $recipe->text = $request->input('приготовление');
        $recipe->time = $request->input('время');
        $recipe->category = $request->input('категория');
        $recipe->approved = ($user->admin === 1) ? 1 : 0;

        // Handle image uploading
        if ($request->hasFile('изображение')) {
            $image = $request->file('изображение');
        	$filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(600, 400)->save(storage_path('app/public/images/' . $filename ));

            $recipe->image = $filename;
		}

        $recipe->save();

        if ($recipe->ready === 0) {
            return redirect()->back()
                    ->with('success', 'Рецепт успешно сохранен');
        } elseif ($recipe->ready === 1 && $user->admin === 1) {
            return redirect('/recipes')
                    ->with('success', 'Рецепт опубликован и доступен для посетителей.');
        }
        return redirect('/dashboard')
                    ->with('success', 'Рецепт добавлен на рассмотрение и будет опубликован после одобрения администрации.');
    }

    // LIKE
    public function like($id)
    {
		Recipe::find($id)->increment('likes');
        return back()->withCookie(cookie('liked', 1, 5000));
	}
	
	// DISLIKE
    public function dislike($id)
    {
		Recipe::find($id)->decrement('likes');
		return back()->withCookie(\Cookie::forget('liked'));
    }

    // APPROVE
    public function answer($id, Request $request)
    {
        $update_recipe = DB::table('recipes')
            ->where([['id', $id], ['approved', 0], ['ready', 1]]);

        if (!$update_recipe) {
            return back();
        } else {
			$recipe = Recipe::find($id);
		}

        if ($request->input('answer') == 'approve') {
			
			$update_recipe->update(['approved' => 1]);

			$message = 'Рецепт под названием "' . $recipe->title . '" был опубликован.';

            DB::table('notifications')->insert([
				'user_id' => $recipe->user_id,
				'title' => 'Рецепт опубликован',
				'message' => $message,
				'for_admins' => 0,
				'created_at' => NOW()
			]);

            return redirect('/recipes')
                    ->with('success', 'Рецепт одобрен и опубликован.');
        } elseif ($request->input('answer') == 'cancel') {

			$update_recipe->update(['ready' => 0]);

			$message = 'Рецепт под названием "' . $recipe->title . '" не был опубликован так как администрация венула его вам на переработку.';

            DB::table('notifications')->insert([
				'user_id' => $recipe->user_id,
				'title' => 'Рецепт не опубликован',
				'message' => $message,
				'for_admins' => 0,
				'created_at' => NOW()
			]);

            return redirect('/recipes')
                    ->with('success', 'Вы вернули рецепт на повторное редактирование.');
        }
    }

    // DESTROY
    public function destroy($id)
    {
		$recipe = Recipe::find($id);
		$user = auth()->user();

        // Check for correct user
        if ($user->id !== $recipe->user_id && $user->admin !== 1) {
            return redirect('/recipes')
                    ->with('error', 'Вы не можете редактировать не свои рецепты.');
        }

        if ($recipe->image != 'default.jpg') {
            Storage::delete('public/images/'.$recipe->image);
        }

        $recipe->delete();
        return redirect('/recipes')
                ->with('success', 'Рецепт успешно удален');
	}
}