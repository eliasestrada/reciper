let mix = require('laravel-mix');

//  Vanilla
var vanillaFilesToCompile = [
	'resources/assets/js/vanilla/modules.js',
	'resources/assets/js/vanilla/materialize.min.js',
	'resources/assets/js/vanilla/functions/_*.js',
	'resources/assets/js/vanilla/components/_*.js',
];

mix.js('resources/assets/js/vue/vue.js', 'public/js')
	.sourceMaps()
	.babel(vanillaFilesToCompile, 'public/js/vanilla.js')
	.sass('resources/assets/sass/app.scss', 'public/css/app.css')
	.browserSync({
		proxy: 'localhost:8000',
		browser: 'firefox',
		files: ['resources/assets/sass/**/*']
	})
	.options({ processCssUrls: false })
	//.disableNotifications()
