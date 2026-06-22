import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/password-strength.js',
                'resources/js/dashboard-charts.js',
                'resources/js/product-form.js',
                'resources/js/reportes-datatable.js',
                'resources/js/toggle-password.js',
                'resources/js/pedidos.js',
                'resources/js/usuarios-datatable.js',
                'resources/js/sidebar.js',
                'resources/js/perfil-form.js',
                'resources/js/productos-datatable.js',
                'resources/js/update-password-form.js',
            ],
            refresh: true,
        }),
    ],
});