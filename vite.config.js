import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/prism.css',
                'resources/css/mail.css',
                'resources/js/app.js',
                'resources/js/thememode.js',
                'resources/js/codekata.js',
                'resources/js/savedkatas.js',
                'resources/js/favorites.js',
                'resources/js/prism.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
});
