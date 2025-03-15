import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Configure apenas em ambiente local
export default defineConfig({
    define: {
        'process.env': {
            VITE_PUSHER_APP_KEY: process.env.VITE_PUSHER_APP_KEY,
            VITE_PUSHER_HOST: process.env.VITE_PUSHER_HOST,
            VITE_PUSHER_PORT: process.env.VITE_PUSHER_PORT,
            VITE_PUSHER_SCHEME: process.env.VITE_PUSHER_SCHEME,
            VITE_PUSHER_APP_CLUSTER: process.env.VITE_PUSHER_APP_CLUSTER,
        },
    },
});
