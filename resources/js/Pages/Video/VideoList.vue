<template>
    <Head>
        <title>{{ title }}</title>
    </Head>
    <h1 class="h1 title-page">{{ title }}</h1>

    <Filters v-if="filterStore.initialized && videos.total > 0"
             :categories="modifiedCategories"
             :tags="tags"
    />

    <div v-if="videos.total > 0" class="mediaList">
        <MediaItem v-for="item in videoItems" :key="item.id" :entity="item" is-card></MediaItem>
    </div>
    <div v-else>Нет данных</div>

    <Pagination v-if="videos.total > 0" :links="videos.links" :total="videos.total" />

</template>

<script setup lang="ts">
import { computed, watch, onMounted } from 'vue';
import { Head } from "@inertiajs/vue3";
import type { PaginatorData, CategoryData, TagData, VideoData } from '@/types';
import Pagination from "@/components/Pagination.vue";
import Filters from "@/components/Filters.vue";
import MediaItem from "@/components/MediaItem.vue";
import { useFilterStore } from '@/stores/filters';

const props = defineProps<{
    title?: string;
    videos: PaginatorData;
    categories: CategoryData[];
    tags: TagData[],
    filters?: Record<string, any>
}>();
const filterStore = useFilterStore();

console.log(props.videos, 'VideoList')

const modifiedCategories = computed(() =>
    props.categories.map(category => ({
        name: category.title,
        value: parseInt(category.id)
    }))
);

const videoItems = computed(() => props.videos.data as VideoData[]);

watch(() => window.location.search, () => {
    filterStore.initFromUrl();
});

onMounted(() => {
    // if (!filterStore.initialized) {
        filterStore.initFromUrl();
    // }
});

</script>

<style scoped></style>
