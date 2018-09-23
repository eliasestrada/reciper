@extends('layouts.app')

@section('title', trans('admin.statistics'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="headline mb-3">@lang('admin.statistics')</h1>
    </div>
    
    <div class="container pb-5">
        <table>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            <tr>
                <td scope="row">@lang('admin.recipes')</td>
                <td>{{ $all_recipes }}</td>
            </tr>
            <tr>
                <td scope="row">@lang('visitors.visitors')</td>
                <td>{{ $all_visitors }}</td>
            </tr>
        </table>
    </div>
</div>

{{ $visitors->links() }}

@endsection