const mix = require('laravel-mix')

const css = 1
const js = 1
const chartjs = 0
const server = 1

if (css == 1) {
    mix.sass('resources/sass/app.sass', 'public/css/app.css').options({
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
    mix.js('resources/js/vue/chart/chart.js', 'public/js/chart.js')
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
        proxy: 'server',
        files: ['public/css/*.css', 'public/js/*.js'],
        notify: false,
    });
}
