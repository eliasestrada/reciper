<li>
	<form action="{{ action('PagesController@search') }}" method="get">
		<div class="input-field">
			<input id="search" type="search" name="for" placeholder="@lang('pages.search_details')" class="fix-input" required>
			<label class="label-icon" for="search"><i class="material-icons">search</i></label>
			<i class="material-icons">close</i>
		</div>
	</form>
</li>