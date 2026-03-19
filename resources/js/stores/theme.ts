import { defineStore } from 'pinia'

interface ThemeState {
    mode: 'light' | 'dark' | 'system'
}

export const useThemeStore = defineStore('theme', {
    state: (): ThemeState => ({
        mode: (localStorage.getItem('theme') as ThemeState['mode']) || 'system'
    }),

    getters: {
        isDark: (state) => {
            if (state.mode === 'system') {
                return window.matchMedia('(prefers-color-scheme: dark)').matches
            }
            return state.mode === 'dark'
        },

        themeClass: (state) => state.mode
    },

    actions: {
        toggleTheme() {
            const modes: ThemeState['mode'][] = ['light', 'dark', 'system']
            const currentIndex = modes.indexOf(this.mode)
            const nextMode = modes[(currentIndex + 1) % modes.length]
            this.setTheme(nextMode)
        },

        setTheme(mode: ThemeState['mode']) {
            this.mode = mode
            localStorage.setItem('theme', mode)
            this.applyTheme()
        },

        applyTheme() {
            const dark = this.isDark

            if (dark) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        }
    }
})
