<template>
    <div v-if="$page.props.auth" as="nav" class="relative bg-gray-500 dark:bg-gray-800/50 dark:after:pointer-events-none dark:after:absolute dark:after:inset-x-0 dark:after:bottom-0 dark:after:h-px dark:after:bg-white/10">
        <div class="container">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <div class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500" @click="toggleMenu">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Открыть меню</span>
                        <Bars3Icon v-if="!isMobileMenuOpen" class="block size-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block size-6" aria-hidden="true" />
                    </div>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <NavigationMenu />
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <ThemeSwitcher />
                    <button type="button" class="relative rounded-full p-1 text-gray-400 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500 dark:hover:text-white">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Смотреть уведомления</span>
                        <BellIcon class="size-6" aria-hidden="true" />
                    </button>


                    <Button type="button" @click="toggle" aria-haspopup="true" aria-controls="overlay_menu" class="bg-transparent border-0 text-gray-400 dark:hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500 p-1 rounded-2xl">
                        <Cog6ToothIcon class="size-6" aria-hidden="true" />
                    </Button>
                    <Menu ref="menu"
                          :model="menuItems"
                          :popup="true"
                          id="overlay_menu"
                    >
                        <template #item="{ item, props }">
                            <Link
                                v-if="item.to"
                                :href="route(item.to)"
                                :class="{ 'active': isRouteActive(item.to) }"
                                v-bind="props.action"
                            >
                                {{ item.label }}
                            </Link>

                            <form v-else-if="item.logout" @submit.prevent="logout" method="POST" v-bind="props.action">
                                <button class="">
                                    {{ item.label }}</button>
                            </form>

                            <a
                                v-else
                                v-bind="props.action"
                            >
                                <span>{{ item.label }}</span>
                            </a>
                        </template>
                    </Menu>
                </div>
            </div>
        </div>

        <div v-if="isMobileMenuOpen" class="fixed inset-0 z-50 sm:hidden">
            <div
                class="fixed inset-0 bg-gray-900/50 dark:bg-gray-600/80 transition-opacity"
                @click="toggleMenu"
            />
            <div class="grid space-y-1 px-2 pt-2 pb-3 fixed top-[3.85rem] left-0 w-full bg-white dark:bg-gray-800 shadow-xl transform transition-transform duration-300 ease-in-out" :class="isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full'">
                <NavigationMenu />
            </div>
        </div>
    </div>

    <div v-if="!$page.props.auth" class="flex justify-end">
        <ThemeSwitcher />
    </div>

    <div class="container">
        <Breadcrumbs />
        <main>
            <slot />
        </main>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { route, current } from "momentum-trail";
import Button from 'primevue/button';
import Menu from 'primevue/menu';
import { Bars3Icon, BellIcon, XMarkIcon, Cog6ToothIcon } from '@heroicons/vue/24/outline'
import ThemeSwitcher from "@/components/ThemeSwitcher.vue";
import NavigationMenu from "@/components/Menu.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";

const menu = ref();
const menuItems = ref([
    {
        items: [
            {
                label: 'Профиль',
                to: 'profile.index',
            },
            {
                label: 'Настройки',
            },
            {
                label: 'Выход',
                logout: true,
            },
        ]
    }
]);

const isRouteActive = (routeName: string) => {
    return current(routeName as any);
};

const _form = useForm({});

const isMobileMenuOpen = ref(false);
const toggleMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
const toggle = (event: Event) => {
    menu.value.toggle(event);
};
const logout = () => {
    _form.post(route('logout'))
}

watch(isMobileMenuOpen, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

watch(() => window.location.pathname, () => {
    isMobileMenuOpen.value = false;
});

</script>

<style scoped>
.transform {
    transition-property: transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
