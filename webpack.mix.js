let mix = require('laravel-mix');

var vanillaFilesToCompile = [
	'resources/assets/js/vanilla/modules.js',
	'resources/assets/js/vanilla/materialize.min.js',
	'resources/assets/js/vanilla/functions/_*.js',
	'resources/assets/js/vanilla/components/_*.js',
];

var combineJsFrom = [
	'public/js/vendor/vanilla.js',
	'public/js/vendor/vue.js'
]

var combineJsTo = 'public/js/app.js'

var browserSyncOptions = {
	proxy: 'localhost:8000',
	browser: 'firefox',
	files: ['resources/assets/sass/**/*']
}

mix.js('resources/assets/js/vue/vue.js', 'public/js/vendor')
	.sourceMaps()
	.babel(vanillaFilesToCompile, 'public/js/vendor/vanilla.js')
	.combine(combineJsFrom, combineJsTo)
	.sass('resources/assets/sass/app.scss', 'public/css/app.css')
	.browserSync(browserSyncOptions)
	.options({ processCssUrls: false })
