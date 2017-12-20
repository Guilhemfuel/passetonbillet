const { mix } = require('laravel-mix');

if(process.env.NODE_ENV != 'production'){
    var BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
}

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

// mix.webpackConfig({
//     plugins: [new BundleAnalyzerPlugin()]
// });

mix.js('resources/assets/js/app.js', 'public/js').version()
    .js('resources/assets/js/admin.js', 'public/js').version()
    .sass('resources/assets/sass/app.scss', 'public/css').version()
    .sass('resources/assets/sass/admin.scss', 'public/css').version()
    .copyDirectory('resources/assets/img', 'public/img');