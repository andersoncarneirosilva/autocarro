import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Configure apenas em ambiente local
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    define: {
        'import.meta.env.VITE_PUSHER_APP_KEY': JSON.stringify('e8703bef27184bc00d2f'),
'import.meta.env.VITE_PUSHER_APP_CLUSTER': JSON.stringify('mt1'),

    },
});
