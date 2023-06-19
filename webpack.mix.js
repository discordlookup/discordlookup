const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')

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

mix
    .options({
        postCss: [
            tailwindcss('./tailwind.config.js'),
        ]
    });

mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css');

mix
    .copy('resources/images', 'public/images')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

mix
    .version()
    .sourceMaps();
