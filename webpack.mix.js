const { mix } = require('laravel-mix');
const webpack = require('webpack');

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



/**
 * Override Laravel Mix Webpack Configuration
 * @type {{chunkFilename: string, publicPath: string}}
 */

mix.options({
    uglify: {
        test: /\.js($|\?)/i
    },
});

mix.config.webpackConfig.output = {
    chunkFilename: 'js/bundles/[name].bundle.js?id=[chunkhash]',
    publicPath: '/',
};

mix.webpackConfig({
    plugins: [
        // Ignore all locale files of moment.js
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
    ],
});

mix.version();


// Language files
let locales = ['fr','en'];
locales.forEach((locale)=> {
    mix.js('resources/assets/js/lang/lang-'+locale+'.js','public/js/lang');

});

// Compiling
mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/admin.js', 'public/js').extract(['vue','element-ui','lodash','moment','pusher-js','vee-validate'])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/admin.scss', 'public/css');


// Copying assets
mix.copyDirectory('resources/assets/img', 'public/img')
    .copyDirectory('resources/assets/audio', 'public/audio')
    .copyDirectory('resources/assets/fonts', 'public/fonts');


if(!mix.inProduction()){

    const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

    mix.webpackConfig({
        plugins: [
            new BundleAnalyzerPlugin(),
        ],
    });


    mix.browserSync({
        open: false,
        files: [
            'app/**/*',
            'public/**/*',
            'resources/views/**/*',
            'routes/**/*'
        ],
        proxy: 'https://lastar.nahum',
        port: 8080,
        node: {
            fs: 'empty',
            child_process: 'empty',
        },
        externals: [
            {pg: true}
        ]
    });
}
