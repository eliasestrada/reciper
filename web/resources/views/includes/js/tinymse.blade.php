<script>
    var editor_config = {
        path_absolute: "{{ url('/') }}/",
        selector: "#text",
        themes: "modern",
        skin: "{{ request()->cookie('r_dark_theme') ? 'dark' : 'light' }}",
        language: '{{ LANG() }}',
        plugins: [
            "autolink lists link preview wordcount fullscreen paste",
        ],
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
        relative_urls: false
    }
    tinymce.init(editor_config)
</script>