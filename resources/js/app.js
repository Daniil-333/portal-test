import { createInertiaApp } from '@inertiajs/vue3'
import { createApp, h } from 'vue';
import { defineRoutes } from 'momentum-trail';
import { createPinia } from 'pinia'
import routes from './routes.json';
import Layout from './Layouts/Layout.vue';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import Aura from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';

// Создаем кастомный пресет для интеграции с вашей темой
const AppPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '#eff6ff',
            100: '#dbeafe',
            200: '#bfdbfe',
            300: '#93c5fd',
            400: '#60a5fa',
            500: '#3b82f6',
            600: '#2563eb',
            700: '#1d4ed8',
            800: '#1e40af',
            900: '#1e3a8a'
        }
    }
});

defineRoutes(routes);

createInertiaApp({
    resolve: name => {

        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });

        const path = `./Pages/${name}.vue`;
        const page = pages[path];

        if (!page) {
            console.error(`Page not found: ${name}`);
            const NotFound = pages['./Pages/Error/404.vue'];
            if (NotFound) {
                NotFound.default.layout = NotFound.default.layout || Layout;
                return NotFound.default;
            }
            throw new Error(`Page ${name} not found`);
        }

        page.default.layout = page.default.layout || Layout;
        return page.default;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .use(PrimeVue, {
                theme: {
                    preset: AppPreset,
                    options: {
                        darkModeSelector: '.dark',
                        cssLayer: {
                            name: 'primevue',
                            order: 'theme, base, primevue, utilities'
                        }
                    }
                }
            })
            .use(ToastService);

        app.mount(el)
    },
    progress: {
        delay: 250,
        color: '#29d',
        includeCSS: true,
        showSpinner: false,
    },
})
