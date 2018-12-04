const mix = require('laravel-mix')

let css = 1
let js = 1
let chartjs = 1
let server = 1

if (css == 1) {
    mix.sass('resources/sass/app.scss', 'public/css/app.css').options({
        processCssUrls: false,
    })
}

if (js == 1) {
    mix.js('resources/js/app.js', 'public/js/app.js')
        .options({
            uglify: {
                uglifyOptions: {
                    compress: {
                        drop_console: true
                    }
                }
            }
        })
        // .sourceMaps();
}

if (chartjs == 1) {
    mix.js('resources/js/chart/chart.js', 'public/js/chart.js')
        .options({
            uglify: {
                uglifyOptions: {
                    compress: {
                        drop_console: true
                    }
                }
            }
        })
}

if (server == 1) {
    mix.browserSync({
        proxy: 'localhost:8000',
        files: ['public/css/*.css', 'public/js/*.js'],
        notify: false,
    });
}
