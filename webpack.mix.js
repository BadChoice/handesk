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

mix.js([
        'resources/assets/js/app.js',
        'resources/assets/js/libs/jquery.tagsinput.min.js'
    ], 'public/js')
    .less('resources/assets/less/style.less',                   '../resources/assets/css/style.css')
    .styles([
        'resources/assets/css/libs/jquery.tagsinput.min.css',
        'resources/assets/css/style.css'
    ],'public/css/all.css');
