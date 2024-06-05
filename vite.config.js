import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/app-creative.min.css',
                'resources/css/icons.min.css',
                'resources/js/jquery-3.7.1.min.js',
                'resources/js/sweetalert2@11.js',
                'resources/js/app.js',
                'resources/js/vendor.min.js',
                'resources/js/app.min.js',
            ],
            refresh: true,
            detectTls: 'warehouse.test',
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        },
    },
});
