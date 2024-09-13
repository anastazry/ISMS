const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .react() // This tells Laravel Mix to process React files
   .sass('resources/sass/app.scss', 'public/css');
