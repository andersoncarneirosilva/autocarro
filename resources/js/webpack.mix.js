const mix = require('laravel-mix');
const dotenv = require('dotenv');
const webpack = require('webpack');

// Carregar as variáveis de ambiente do arquivo .env
dotenv.config();

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .webpackConfig({
        plugins: [
            new webpack.DefinePlugin({
                'process.env.PUSHER_APP_KEY': JSON.stringify(process.env.PUSHER_APP_KEY),
                'process.env.PUSHER_APP_CLUSTER': JSON.stringify(process.env.PUSHER_APP_CLUSTER),
            })
        ]
    });
