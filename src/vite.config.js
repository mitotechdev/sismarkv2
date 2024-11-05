import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dselect.css',
                'resources/js/app.js',
                'resources/js/dselect.js',
                'resources/js/confirm.js'
            ],
            refresh: [
                'app/Http/Controllers/**',
                'resources/views/**'
            ],
        }),
    ],
});
