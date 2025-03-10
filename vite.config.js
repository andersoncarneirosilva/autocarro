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
        host: '0.0.0.0',  // Permite que o servidor seja acessado de fora do localhost
        port: 5173,        // Porta padrão, altere se necessário
        https: false,      // Desativa o HTTPS (se necessário, configure o HTTPS)
        strictPort: true,  // Garante que a porta será 5173 e não outra
    },
});
