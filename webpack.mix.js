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

var options = {
	processCssUrls: false
}

var sync = {
	proxy: 'localhost:8000',
	browser: 'chrome',
	files: [
		'public/css/*.css',
		'public/js/*.js'
	]
}

mix.sass('resources/assets/sass/app.scss', 'public/css')
	.babel('resources/assets/js/*.js', 'public/js/app.js')
	.disableNotifications()
	.browserSync(sync)
	.options(options)