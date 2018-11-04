@forelse ($recipes->chunk(4) as $chunk)
    <div class="row">
        @foreach ($chunk as $recipe)
            <div class="col s12 m6 l3">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a href="/recipes/{{ $recipe->slug }}">
                            <img src="{{ asset('storage/small/recipes/'.$recipe->image) }}" class="activator" alt="{{ $recipe->getTitle() }}">
                        </a>
                    </div>
                    <div class="card-content min-h">
                        <span style="height:75%" class="card-title activator">
                            {{ $recipe->getTitle() }}
                        </span>
                        <div style="height:25%">
                            <div>
                                <div class="left">
                                    <btn-favs recipe-id="{{ $recipe->id }}" :favs="{{ $recipe->favs }}" :user-id="{{ auth()->check() ? user()->id : 'null' }}">
                                        <i class="star d-inline-block grey circle mx-2" style="width:10px;height:10px;"></i> 
                                        ...
                                    </btn-favs>
                                </div>
                            </div>
                            <span class="left card-time">
                                <i class="fas fa-clock fa-1x z-depth-2 main-light circle red-text ml-5 mr-1"></i>
                                {{ $recipe->time }} @lang('recipes.min').
                            </span>
                            <i class="fas fa-ellipsis-h fa-15x right red-text activator px-1"></i>
                        </div>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title">{{ $recipe->getTitle() }}</span>
                        <div><i class="fas fa-times right red-text card-title p-1"></i></div>
                        <a class="btn-small mt-3" href="/recipes/{{ $recipe->slug }}">
                            @lang('messages.go')
                        </a>
                        <p>{{ $recipe->getIntro() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@empty
    @component('comps.empty')
        @slot('text')
            {{ ($no_recipes ?? trans('users.no_recipes')) }}
        @endslot
    @endcomponent
@endforelse