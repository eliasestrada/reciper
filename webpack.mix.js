let mix = require("laravel-mix");

mix.js("resources/js/vue/vue.js", "public/js/vendor")
    .sourceMaps()
    .babel(
        [
            "resources/js/vanilla/modules.js",
            "resources/js/vanilla/materialize.min.js",
            "resources/js/vanilla/functions/_*.js",
            "resources/js/vanilla/components/_*.js"
        ],
        "public/js/vendor/vanilla.js"
    )
    .combine(
        ["public/js/vendor/vue.js", "public/js/vendor/vanilla.js"],
        "public/js/app.js"
    )
    .sass("resources/sass/app.scss", "public/css/app.css")
    // .browserSync({
    //     proxy: "localhost:8000",
    //     files: ["resources/sass/**/*", "resources/js/**/*"]
    // })
    .options({
        processCssUrls: false
    });
