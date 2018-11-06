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

mix.babel([
        //'resources/assets/js/app.js',
        'vendor/badchoice/thrust/src/resources/js/thrust.min.js',
        'resources/assets/js/utils.js',
        'resources/assets/js/libs/jquery.tagsinput.min.js',  //http://xoxco.com/projects/code/tagsinput/
        'resources/assets/js/libs/mention.js/bootstrap-typeahead.js',  //https://github.com/ivirabyan/jquery-mentions
        'resources/assets/js/libs/mention.js/mention.js',  //https://github.com/ivirabyan/jquery-mentions
    ], 'public/js/app.js')
    .babel('resources/assets/js/moment.min.js'                 ,'public/js/moment.js')
    .less('resources/assets/less/style.less',                  '../resources/assets/css/style.css')
    .styles([
        'resources/assets/css/libs/jquery.tagsinput.min.css',
        'resources/assets/css/style.css'
    ],'public/css/all.css');
