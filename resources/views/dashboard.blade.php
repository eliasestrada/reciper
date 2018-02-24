@extends('layouts.app')
@section('content')

    <h3>Панель управления</h3>
    <h4>{{ ucfirst(Auth::user()->name) }}</h4>
    <br /><hr /><br />

    <a href="{{ url('/recipes/create') }}" title="Добавить рецепт" class="button">Добавить рецепт</a>

    @if (count($recipes) > 0)
        <table style="width:90%; margin: .5rem 5%; border-bottom: solid 1px;">
            @foreach ($recipes as $recipe)
                <tr>
                    <td>
                        <p class="content">{{ $recipe->title }}</p>
                    </td>
                    <td>
                        <a href="{{ url('/recipes/'.$recipe->id.'/edit') }}" class="button">Изменить</a>
                    </td>
                    <td>
                        {!! Form::open(['action' => ['RecipesController@destroy', $recipe->id], 'method' => 'post']) !!}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('Delete', ['class' => 'button', 'style' => 'background: brown;']) }}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="content">У вас еще нет рецептов.</p>
    @endif

@endsection
