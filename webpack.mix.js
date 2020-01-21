let mix = require("laravel-mix");

mix.js("resources/assets/js/main.js", "public/js")
    .sass("resources/assets/sass/app.scss", "public/css");

mix.webpackConfig({
    resolve: {
        alias: {
        'components' :  __dirname + '/resources/js/components',
        'services' :  __dirname + '/resources/js/services',
        },
    },
})
