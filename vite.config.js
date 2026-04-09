import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/admin/diseno.css',
                'resources/css/pages/biblioteca.css',
                'resources/css/pages/bolsa-trabajo.css',
                'resources/css/anuncios-slider.css',
                'resources/js/app.js',
                'resources/js/admin/diseno.js',
                'resources/js/admin-bulk-actions.js',
                'resources/js/modules/mision-vision.js',
                'resources/js/modules/consejo.js',
                'resources/js/modules/historia.js',
                'resources/js/modules/login.js',
                'resources/js/modules/noticias.js',
                'resources/js/anuncios-slider.js',
                'resources/css/pages/galeria.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
