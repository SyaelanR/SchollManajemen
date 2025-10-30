import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: '0.0.0.0',   // penting: izinkan semua koneksi
    //     port: 5173,        // optional: ubah jika bentrok
    //     cors: true,
    //     hmr: {
    //         host: '192.168.1.10',
    //     },
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
