<footer class="px-5 pt-3 pb-5">
    <div class="row wrapper">
        {{--  Documents  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('documents.documents')</strong></li>
                @foreach ($documents_footer as $doc)
                    <li>
                        <a href="/documents/{{ $doc->id }}">
                            <i class="fas fa-angle-right red-text"></i> {{ $doc->getTitle() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{--  Random recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('includes.recipes')</strong></li>
                @foreach ($random_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe->id }}">
                            <i class="fas fa-angle-right red-text"></i> {{ $recipe->getTitle() }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{--  Popular recipes  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('includes.popular_recipes')</strong></li>
                @foreach ($popular_recipes as $recipe)
                    <li>
                        <a href="/recipes/{{ $recipe->id }}">
                            <i class="fas fa-angle-right red-text"></i> {{ $recipe->getTitle() }}
                        </a>
                    </li>
                @endforeach
            <ul>
        </div>

        {{--  Top recipers  --}}
        <div class="col s12 m6 l3 left-align">
            <ul class="unstyled-list">
                <li><strong>@lang('includes.top_recipers')</strong></li>
                @foreach ($top_recipers as $i => $reciper)
                    <li>
                        <a href="/users/{{ $reciper->id }}">
                            <i class="fas fa-star" style="font-size:0.8em;color:orange"></i> 
                            {{ $reciper->name }} ({{ $reciper->exp }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="center">
        <div><a href="/contact">@lang('feedback.contact_us')</a></div>
        <p class="footer-copyright">
            &copy; {{ date('Y') }} {{ config('app.name') }} <br> {{ $title_footer ?? '' }}
        </p>
    </div>

    @hasRole('admin')
        {{--  Настройки подвала  --}}
        <div class="position-relative">
            <a class="magic-btn" title="@lang('home.edit_banner')" id="btn-for-footer">
                <i class="fa fa-pen"></i>
            </a>
            @magicForm
                @slot('id')
                    footer-form
                @endslot
                @slot('text')
                    {{ $title_footer }}
                @endslot
                @slot('action')
                    TitleController@footer
                @endslot
                @slot('holder_text')
                    @lang('home.footer_text')
                @endslot
                @slot('slug_text')
                    footer_text
                @endslot
            @endmagicForm
        </div>
    @endhasRole
</footer>