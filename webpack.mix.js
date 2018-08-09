let mix = require('laravel-mix');

var vanillaFilesToCompile = [
	'resources/js/vanilla/modules.js',
	'resources/js/vanilla/materialize.min.js',
	'resources/js/vanilla/functions/_*.js',
	'resources/js/vanilla/components/_*.js',
];

var combineJsFrom = [
	'public/js/vendor/vanilla.js',
	'public/js/vendor/vue.js'
]

var combineJsTo = 'public/js/app.js'

var browserSyncOptions = {
	proxy: 'localhost:8000',
	browser: 'firefox',
	files: ['resources/sass/**/*']
}

mix.js('resources/js/vue/vue.js', 'public/js/vendor')
	.sourceMaps()
	.babel(vanillaFilesToCompile, 'public/js/vendor/vanilla.js')
	.combine(combineJsFrom, combineJsTo)
	.sass('resources/sass/app.scss', 'public/css/app.css')
	.browserSync(browserSyncOptions)
	.options({ processCssUrls: false })
