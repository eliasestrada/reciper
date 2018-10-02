@forelse ($recipes->chunk(4) as $chunk)
    <div class="row">
        @foreach ($chunk as $recipe)
            <div class="col s12 m6 l3">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a href="/recipes/{{ $recipe->id }}">
                            <img class="activator" alt="{{ $recipe->getTitle() }}" src="{{ asset('storage/images/small/'.$recipe->image) }}">
                        </a>
                    </div>
                    <div class="card-content min-h">
                        <span style="height:75%" class="card-title activator">
                            {{ $recipe->getTitle() }}
                        </span>
                        <div style="height:25%">
                            <i class="fas fa-ellipsis-h fa-15x right red-text activator"></i>
                        </div>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title">{{ $recipe->getTitle() }}</span>
                        <div><i class="fas fa-times right red-text card-title"></i></div>
                        <a class="btn-small mt-3" href="/recipes/{{ $recipe->id }}">
                            @lang('recipes.go')
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