const mix = require('laravel-mix');
const path = require("path");
const packageJson = require('./package.json');

mix.js('resources/js/app.js', 'public/js').sourceMaps();
mix.react();
mix.sass('resources/sass/app.scss', 'public/css', {sourceMap: true});
mix.webpackConfig({
    devtool: 'inline-source-map'
});
mix.options({
    hmrOptions: {
        host: 'localhost',
        port: 8081
    }
});

// Additional mix configuration, e.g., CSS compilation, versioning, etc.

mix.alias({
    '~': path.resolve(__dirname, 'resources/js')
});
