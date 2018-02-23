<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipesController extends Controller
{
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
            'название' => 'required',
            'описание' => 'required'
        ]);

        // Create Recipe in DB
        $recipe = new Recipe;
        $recipe->title = $request->input('название');
        $recipe->intro = $request->input('описание');
        $recipe->ingredients = '';
        $recipe->advice = '';
        $recipe->text = '';
        $recipe->time = 0;
        $recipe->category = '';
        $recipe->approved = 0;
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
            'описание' => 'required|string|min:10|max:1000'
        ]);

        // Create Recipe in DB
        $recipe = Recipe::find($id);
        $recipe->title = $request->input('название');
        $recipe->intro = $request->input('описание');
        $recipe->ingredients = '';
        $recipe->advice = '';
        $recipe->text = '';
        $recipe->time = 0;
        $recipe->category = '';
        $recipe->approved = 0;
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
        $recipe->delete();
        return redirect('/recipes')->with('success', 'Рецепт успешно удален');
    }
}
