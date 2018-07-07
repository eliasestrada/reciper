<script>
	var editor_config = {
		path_absolute: "{{ URL::to('/') }}/",
		selector: "#text",
		themes: "modern",
		skin: "light",
		language: '{{ locale() }}',
		plugins: [
			"autolink lists link preview wordcount fullscreen paste",
		],
		toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
		relative_urls: false
	}
	tinymce.init(editor_config)
</script>