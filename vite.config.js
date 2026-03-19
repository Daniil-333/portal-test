import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { watch } from 'vite-plugin-watch';
import tailwindcss from '@tailwindcss/vite'
import * as path from "node:path";

export default defineConfig(({command, mode}) => {
    const env = loadEnv(mode, process.cwd(), '');
    const devHost = env.VITE_DEV_HOST || 'localhost';
    const isHttps = env.APP_URL?.startsWith('https');

    const config = {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/sass/app.scss',
                    'resources/js/app.js',
                ],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    }
                }
            }),
            tailwindcss(),
        ],
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js'),
                vue: 'vue/dist/vue.esm-bundler.js',
            }
        },
        esbuild: {
            tsconfigRaw: {
                compilerOptions: {
                    experimentalDecorators: true,
                },
            },
        },
    };

    if (command === 'serve') {
        config.server = {
            host: devHost,
            port: 5173,
            strictPort: true,
            https: isHttps,
            cors: {
                origin: [env.APP_URL || `http://${devHost}`],
                credentials: true,
            },
            hmr: {
                host: devHost,
                protocol: 'ws'
            },
        };

        config.plugins.push(
            watch({
                pattern: 'routes/*.php',
                command: 'php artisan trail:generate',
            }),
            watch({
                pattern: 'app/{Data,Enums}/**/*.php',
                command: 'php artisan typescript:transform --format',
            })
        );
    }
    else {
        config.build = {
            minify: 'terser',
            terserOptions: { format: { comments: false } }
        }
    }

    return config;
});