<ul class="collapsible">
    <li id="collapsible-li-tag">
        <div class="collapsible-header px-1 py-3 center">
            <span class="d-inline-block m-auto">
                <i class="fas fa-cog mr-1 fa-15x grey-text"></i>
                <h6 class="d-inline">@lang('settings.settings')</h6>
                <i class="fas fa-caret-down fa-15x grey-text"></i>
            </span> 
        </div>
        <div class="collapsible-body p-0">
            <ul class="collection with-header">
                <a href="/settings/general" class="collection-item {{ active_if_route_is(['settings/general', 'settings']) }}">
                    <b>@lang('settings.general')</b>. 
                    <span class="grey-text">@lang('settings.general_desc')</span>
                </a>
                <a href="/settings/photo" class="collection-item {{ active_if_route_is(['settings/photo']) }}">
                    <b>@lang('settings.photo')</b>. 
                    <span class="grey-text">@lang('settings.photo_desc')</span>
                </a>
            </ul>
        </div>
    </li>
</ul>
