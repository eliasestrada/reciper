@extends('layouts.app')
@section('content')

    <h2>Админ панель</h2>
    <br /><hr /><br />

    <a href="{{ url('/recipes/create') }}" title="Добавить рецепт" class="button">Добавить рецепт</a>

    @if (count($recipes) > 0)
        <table>
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
