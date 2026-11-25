import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    base: './',
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: [
                    'import',
                    'color-functions',
                    'global-builtin',
                    'if-function',
                    'abs-percent',
                ],
            },
        },
    },
    build: {
        chunkSizeWarningLimit: 1000,
        rolldownOptions: {
            checks: {
                pluginTimings: false,
            },
        },
    },
});
