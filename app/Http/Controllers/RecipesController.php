<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Recipe;

class RecipesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::where('approved', 1)
                        ->latest()
                        ->paginate(30);
        return view('recipes.index')->with('recipes', $recipes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'название' => 'required|string|min:5|max:255',
            'описание' => 'required|string|min:10|max:1000',
            'изображение' => 'image|nullable|max:1999'
        ]);

        // Handle file uploading
        if ($request->hasFile('изображение')) {
            // Get filename
            $filenameWithExt = $request->file('изображение')->getClientOriginalName();
            // Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get extention
            $extension = $request->file('изображение')->getClientOriginalExtension();
            $fileNameToStore = 'recipe-' . Recipe::find($id)->id . '.' . $extension;
            // Upload
            $path = $request->file('изображение')->storeAs('public/images', $fileNameToStore);
        } else {
            $fileNameToStore = 'default.jpg';
        }

        // Create Recipe in DB
        $recipe = new Recipe;
        $recipe->title = $request->input('название');
        $recipe->intro = $request->input('описание');
        $recipe->ingredients = '';
        $recipe->advice = '';
        $recipe->text = '';
        $recipe->time = 0;
        $recipe->category = '';
        $recipe->approved = 1;
        $recipe->user_id = auth()->user()->id;
        $recipe->image = $fileNameToStore;
        $recipe->save();

        return redirect('/recipes')->with('success', 'Добавленно');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::find($id);
        return view('recipes.show')->with('recipe', $recipe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);

        // Check for correct user
        if (auth()->user()->id !== $recipe->user_id) {
            return redirect('/recipes')->with('error', 'Вы не можете редактировать не свои рецепты.');
        }

        return view('recipes.edit')->with('recipe', $recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'название' => 'required|string|min:5|max:255',
            'описание' => 'required|string|min:10|max:1000',
            'изображение' => 'image|nullable|max:1999'
        ]);

        // Handle file uploading
        if ($request->hasFile('изображение')) {
            // Get filename
            $filenameWithExt = $request->file('изображение')->getClientOriginalName();
            // Get filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get extention
            $extension = $request->file('изображение')->getClientOriginalExtension();
            $fileNameToStore = 'recipe-' . Recipe::find($id)->id . '.' . $extension;
            // Upload
            $path = $request->file('изображение')->storeAs('public/images', $fileNameToStore);
        }

        // Create Recipe in DB
        $recipe = Recipe::find($id);
        $recipe->title = $request->input('название');
        $recipe->intro = $request->input('описание');
        $recipe->ingredients = '';
        $recipe->advice = '';
        $recipe->text = '';
        $recipe->time = 0;
        $recipe->category = '';
        $recipe->approved = 1;
        if ($request->hasFile('изображение')) {
            $recipe->image = $fileNameToStore;
        }
        $recipe->save();

        return redirect('/recipes')->with('success', 'Рецепт успешно изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        // Check for correct user
        if (auth()->user()->id !== $recipe->user_id) {
            return redirect('/recipes')->with('error', 'Вы не можете редактировать не свои рецепты.');
        }

        if ($recipe->image != 'default.jpg') {
            Storage::delete('public/images/'.$recipe->image);
        }

        $recipe->delete();
        return redirect('/recipes')->with('success', 'Рецепт успешно удален');
    }
}
