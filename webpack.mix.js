let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

var jsFilesToCompile = [
	'resources/assets/js/modules.js',
	'resources/assets/js/functions/_*.js',
	'resources/assets/js/_*.js',
];

mix.babel(jsFilesToCompile, 'public/js/app.js')
	.sass('resources/assets/sass/app.scss', 'public/css/app.css')
	.disableNotifications()
	.browserSync({
		proxy: 'localhost:8000',
		browser: 'chrome',
		files: ['resources/assets/sass/**/*']
	})
	.options({processCssUrls: false})
