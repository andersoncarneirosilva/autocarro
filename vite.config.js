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
    server: {
        // Só ativa o servidor do Vite em ambiente de desenvolvimento
        host: process.env.APP_ENV === 'local' ? 'localhost' : false, 
        port: 5173,
        strictPort: true,
    },
});
