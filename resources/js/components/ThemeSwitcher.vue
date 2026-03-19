<template>
    <div class="relative group">
        <button
            @click="themeStore.toggleTheme"
            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-xl"
            :title="`Текущая тема: ${themeStore.mode}`"
        >
            {{ icon }}
        </button>

        <div class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
            <div class="py-1">
                <button
                    v-for="mode in modes"
                    :key="mode.value"
                    @click="themeStore.setTheme(mode.value)"
                    class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                    :class="{
                        'bg-primary-100 dark:bg-primary-900': themeStore.mode === mode.value,
                        'text-gray-700 dark:text-gray-200': true
                    }"
                >
                    {{ mode.label }}
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, watch, onMounted, computed } from "@vue/runtime-core";
import { useThemeStore } from '@/stores/theme'
import {ref} from "@vue/runtime-dom";

export default defineComponent({
    name: "ThemeSwitcher",

    setup() {
        const themeStore = useThemeStore()
        const showThemeMenu = ref(false);

        // Применяем тему при загрузке
        onMounted(() => {
            themeStore.applyTheme()

            // Следим за системными изменениями
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (themeStore.mode === 'system') {
                    themeStore.applyTheme()
                }
            })
        })

        // Следим за изменениями mode
        watch(() => themeStore.mode, () => {
            themeStore.applyTheme()
        })

        const icon = computed(() => {
            if (themeStore.isDark) {
                return '🌙' // луна для темной
            }
            return '☀️' // солнце для светлой
        })

        return {
            themeStore,
            icon,
            modes: [
                { value: 'light', label: '☀️ Светлая' },
                { value: 'dark', label: '🌙 Темная' },
                { value: 'system', label: '💻 Системная' }
            ],
            showThemeMenu
        }
    }
});
</script>

<style scoped>

</style>
