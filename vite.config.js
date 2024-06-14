import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';
import { resolve } from 'path';

// Load environment variables from .env
dotenv.config({ path: resolve(__dirname, '.env') });

// Log loaded environment variables for debugging
console.log('Loaded environment variables:', process.env);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js'
            ],
            refresh: true,
        }),
    ],
});
