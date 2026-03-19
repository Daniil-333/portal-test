import { defineStore } from 'pinia';
import { router } from '@inertiajs/vue3';
import { debounce } from "@/helpers.ts";
import type {SelectChangeEvent} from "primevue/select";

interface FilterState {
    search: string;
    category: number | null;
    tags: number[];
    sortView: string | null;
    sortBy: string | null;
    initialized: boolean;
}

export const useFilterStore = defineStore('filters', {
    state: (): FilterState => ({
        search: '',
        category: null,
        tags: [],
        sortView: null,
        sortBy: null,
        initialized: false
    }),

    getters: {
        urlParams: (state): Record<string, any> => {
            const params: Record<string, any> = {};

            if (state.search) params.search = state.search;
            if (state.category) params.category = state.category;
            if (state.tags.length) params.tags = state.tags.join(',');

            if (state.sortView && state.sortBy) {
                params.sort = `${state.sortView}:${state.sortBy}`;
            }

            return params;
        },

        hasActiveFilters: (state) => {
            return !!(state.search || state.category || state.tags.length || state.sortView);
        },

        sortViewOptions: () => [
            { id: 'По актуальности', value: 'created_at' },
            { id: 'По имени', value: 'title' }
        ],

        sortByOptions: () => [
            { id: 'По возрастанию', value: 'asc' },
            { id: 'По убыванию', value: 'desc' }
        ]
    },

    actions: {
        initFromUrl() {
            const url = new URL(window.location.href);
            const params = url.searchParams;

            this.search = params.get('search') || '';
            this.category = params.get('category') ? Number(params.get('category')) : null;

            const tagsParam = params.get('tags');
            this.tags = tagsParam ? tagsParam.split(',').map(Number) : [];

            const sortParam = params.get('sort');
            if (sortParam) {
                const [field, direction] = sortParam.split(':');
                this.sortView = field || null;
                this.sortBy = direction || null;
            } else {
                this.sortView = null;
                this.sortBy = null;
            }

            this.initialized = true;

            // console.log('Filters initialized from URL:', this.urlParams);
        },

        async applyFilters(options: { replace?: boolean } = {}) {
            const url = new URL(window.location.href);
            const params = this.urlParams;

            Object.entries(params).forEach(([key, value]) => {
                url.searchParams.set(key, String(value));
            });

            Array.from(url.searchParams.keys()).forEach(key => {
                if (!params.hasOwnProperty(key)) {
                    url.searchParams.delete(key);
                }
            });

            await router.get(url.pathname + url.search, {}, {
                preserveState: true,
                preserveScroll: true,
                replace: options.replace || false
            });
        },

        debouncedApply: debounce(function(this: any) {
            this.applyFilters();
        }, 300),

        async resetFilters() {
            this.search = '';
            this.category = null;
            this.tags = [];
            this.sortView = null;
            this.sortBy = null;

            await router.get(window.location.pathname, {}, {
                preserveState: true,
                preserveScroll: true,
                replace: true
            });
        },

        clearSortBy(event: SelectChangeEvent) {
            if(!event.value) this.sortBy = null;
        }
    }
});
