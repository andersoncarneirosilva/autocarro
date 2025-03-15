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
        'process.env': {
            VITE_PUSHER_APP_KEY: process.env.VITE_PUSHER_APP_KEY,
            VITE_PUSHER_HOST: process.env.VITE_PUSHER_HOST,
            VITE_PUSHER_PORT: process.env.VITE_PUSHER_PORT,
            VITE_PUSHER_SCHEME: process.env.VITE_PUSHER_SCHEME,
            VITE_PUSHER_APP_CLUSTER: process.env.VITE_PUSHER_APP_CLUSTER,
        },
    },
    server: {
        // Só ativa o servidor do Vite em ambiente de desenvolvimento
        host: process.env.APP_ENV === 'local' ? 'localhost' : false,
        port: 5173, // Porta do servidor de desenvolvimento
        strictPort: true, // Força a Vite a usar a porta 5173 ou falhar se já estiver ocupada
        open: true, // Opcional: abre o navegador automaticamente
    },
});
