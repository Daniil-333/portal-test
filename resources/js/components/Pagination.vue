<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 dark:border-white/10 dark:bg-transparent">
        <div class="flex flex-1 justify-between md:hidden">
            <Link :href="links[0]?.url ?? '#'"
                  :disabled="!links[0].url"
                  :class="classesMobileLink"
                  as="button"
            >Назад</Link>
            <Link :href="links[links.length - 1].url ?? '#'"
                  :disabled="!links[links.length - 1].url"
                  :class="classesMobileLink"
                  as="button"
            >Вперёд</Link>
        </div>
        <div class="hidden md:flex md:flex-1 md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">1</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ links.length - 2 }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs dark:shadow-none" aria-label="Pagination">
                    <template v-for="(link, k) in links">
                        <Link v-if="k === 0"
                              :href="link.url ?? '#'"
                              :class="classesDesktopLink"
                              :disabled="link.url === null"
                              as="button">
                            <ChevronLeftIcon class="size-5" aria-hidden="true" />
                        </Link>

                        <Link v-else-if="k === links.length - 1"
                              :href="link.url ?? '#'"
                              :class="classesDesktopLink"
                              :disabled="link.url === null"
                              as="button">
                            <ChevronRightIcon class="size-5" aria-hidden="true" />
                        </Link>

                        <Link v-else
                              :href="link.url ?? '#'"
                              :disabled="!link.url"
                              :class="[link.active ? classLinkActive : '', classesDesktopLink]"
                        >
                            {{ link.label }}
                        </Link>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';
    import { Link } from "@inertiajs/vue3";
    import type { PaginatorLinksData } from "@/types";

    defineProps<{
        links: PaginatorLinksData[];
        total: number
    }>();

    const classesMobileLink = 'relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-white/10 dark:bg-white/5 dark:text-gray-200 dark:hover:bg-white/10';
    const classesDesktopArrow = 'relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 inset-ring inset-ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 dark:inset-ring-gray-700 dark:hover:bg-white/5';
    const classesDesktopLink = 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 inset-ring inset-ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 dark:text-gray-200 dark:inset-ring-gray-700 dark:hover:bg-white/5';
    const classLinkActive = 'z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:focus-visible:outline-indigo-500", Default: "text-gray-900 inset-ring inset-ring-gray-300 hover:bg-gray-50 focus:outline-offset-0 dark:text-gray-200 dark:inset-ring-gray-700 dark:hover:bg-white/5';
</script>

<style scoped></style>
