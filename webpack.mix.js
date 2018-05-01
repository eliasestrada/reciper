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

var components = [
	'public/js/components/app.js'
]

var options = {
	processCssUrls: false
}

var sync = {
	proxy: 'localhost:8000',
	browser: 'chrome',
	files: [ 'public/css/*.css' ]
}

mix.sass('resources/assets/sass/app.scss', 'public/css')
	.scripts(components, 'public/js/app.js')
	.disableNotifications()
	.browserSync(sync)
	.options(options)