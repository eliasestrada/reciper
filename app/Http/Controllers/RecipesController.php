<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Cookie\CookieJar;
use App\Recipe;

class RecipesController extends Controller
{
    // Create a new controller instance.
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'like']]);
    }

    // INDEX
    // Display a listing of the resource.
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
    // Store a newly created resource in storage.
    public function store(Request $request)
    {

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
        $recipe->user_id = auth()->user()->id;
        $recipe->author = auth()->user()->name;
        $recipe->image = 'default.jpg';

        $recipe->save();

        // Handle file uploading
        if ($request->hasFile('изображение')) {

            // Get filename
            $filenameWithExt = $request
                    ->file('изображение')
                    ->getClientOriginalName();

            // Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get extention
            $extension = $request
                    ->file('изображение')
                    ->getClientOriginalExtension();

            $fileNameToStore = 'recipe-' . $recipe->id . '-by-' . auth()
                    ->user()->id . '.' . $extension;

            // Upload
            $path = $request->file('изображение')
                    ->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'default.jpg';
        }

        $recipe->image = $fileNameToStore;
        $recipe->save();

        return redirect('/recipes/'.$recipe->id.'/edit')->with('success', 'Рецепт успешно сохранен');
    }

    // SHOW
    // Display the specified resource.
    public function show($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return redirect('/recipes');
        }

        $recipe = Recipe::find($id);

        if (!$recipe) {
            return redirect('/recipes');
        }

        // FIXME: Make it more cleaner. Too much if statements
        if (empty(auth()->user()->id) && $recipe->approved == 0) {
            return redirect('/recipes');
        } elseif (auth()->user()->admin == 1) {
            return view('recipes.show')->with('recipe', $recipe);
        } elseif (auth()->user()->id != $recipe->user_id && $recipe->approved == 0 && auth()->user()->author !== 1) {
            return redirect('/recipes');
        } 

        return view('recipes.show')->with('recipe', $recipe);
    }

    // EDIT
    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $recipe = Recipe::find($id);

        // Check for correct user
        if (auth()->user()->id !== $recipe->user_id) {
            return redirect('/recipes')->with('error', 'Вы не можете редактировать не свои рецепты.');
        }

        if ($recipe->ready == 1) {
            return redirect('/recipes')->with('error', 'Вы не можете редактировать рецепты которые находятся на рассмотрении.');
        }

        // For select input
        $categories = DB::table('categories')->get();

        return view('recipes.edit')
                            ->withRecipe($recipe)
                            ->withCategories($categories);
        
    }

    // UPDATE
    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {

        // If ready to publish
        if (isset($request->ready)) {
            $this->validate($request, [
                'название' => 'min:5|max:199',
                'описание' => 'min:20|max:2000',
                'ингридиенты' => 'min:20|max:5000',
                'совет' => 'max:5000',
                'приготовление' => 'min:100|max:10000',
                'время' => 'numeric|digits_between:0,1000',
                'изображение' => 'image|nullable|max:1999'
            ]);
        }

        $this->validate($request, [
            'название' => 'max:199',
            'описание' => 'max:2000',
            'ингридиенты' => 'max:5000',
            'совет' => 'max:5000',
            'приготовление' => 'max:10000',
            'время' => 'numeric|digits_between:0,1000',
            'изображение' => 'image|nullable|max:1999'
        ]);

        // Handle file uploading
        if ($request->hasFile('изображение')) {

            // Get filename
            $filenameWithExt = $request
                    ->file('изображение')
                    ->getClientOriginalName();

            // Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get extention
            $extension = $request
                    ->file('изображение')
                    ->getClientOriginalExtension();

            $fileNameToStore = 'recipe-' . $id . '-by-' . auth()
                    ->user()->id . '.' . $extension;

            // Upload
            $path = $request
                    ->file('изображение')
                    ->storeAs('public/images', $fileNameToStore);
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

        if ($request->hasFile('изображение')) {
            $recipe->image = $fileNameToStore;
        }

        if (isset($request->ready)) {
            DB::table('users')->where('admin', 1)->update(['notif' => 1]);
        }

        $recipe->save();

        return $recipe->ready == 0
                ? redirect()->back()->with('success', 'Рецепт успешно сохранен')
                : redirect('/dashboard')->with('success', 'Рецепт добавлен на рассмотрение и будет опубликован после одобрения администрации.');
    }

    // LIKE
    public function like($id, Request $request)
    {
        $recipe = DB::table('recipes')->where('id', $id);

        if ($request->input('todo') == 'set') {
            // +1 like
            $recipe->increment('likes');
            return back()->withCookie(cookie('liked', 1, 5000));

        } elseif ($request->input('todo') == 'delete') {
            // -1 like
            $recipe->decrement('likes');
            $cookie = \Cookie::forget('liked');
            return back()->withCookie($cookie);
        }
        return back()->withCookie($cookie);
    }

    // APPROVE
    public function answer($id, Request $request)
    {
        $recipe = DB::table('recipes')
            ->where([['id', $id], ['approved', 0]]);

        if (!$recipe) {
            return back();
        }

        if ($request->input('answer') == 'approve') {
            $recipe->update(['approved' => 1]);
            // TODO: Notification to author if author is not admin, that his recipe has been posted
            return redirect('/recipes')
                    ->with('success', 'Рецепт одобрен и опубликован.');
        } elseif ($request->input('answer') == 'cancel') {
            $recipe->update(['ready' => 0]);
            // TODO: Notification to author if author is not admin, that he needs to edit the recipe
            return redirect('/recipes')
                    ->with('success', 'Вы вернули рецепт на повторное редактирование.');
        }
    }

    // DESTROY
    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        // Check for correct user
        if (auth()->user()->id !== $recipe->user_id) {
            return redirect('/recipes')
                    ->with('error', 'Вы не можете редактировать не свои рецепты.');
        }

        if ($recipe->image != 'default.jpg') {
            Storage::delete('public/images/'.$recipe->image);
        }

        $recipe->delete();
        return redirect('/dashboard')
                ->with('success', 'Рецепт успешно удален');
    }
}
