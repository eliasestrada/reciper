<div class="px-3 pt-3">
	<a href="/" class="breadcrumb">@lang('includes.home')</a>
	@isset($url, $name)
		@for ($i = 0; $i < count($url); $i++)
			<a href="{{ $url[$i] }}" class="breadcrumb">{{ $name[$i] }}</a>
		@endfor
	@endisset
</div>