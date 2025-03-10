import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

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
        host: '147.182.231.89',
        port: 5173,
        https: false,  // Certifique-se de usar HTTP se não tiver HTTPS configurado
        strictPort: true,
    }
    
});
