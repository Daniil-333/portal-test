<template>
    <Head>
        <title>{{ title }}</title>
    </Head>
    <h1 class="h1">{{ title }}</h1>

    <MediaItem :entity="video"></MediaItem>

</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import type { VideoData } from '@/types';
import MediaItem from "@/components/MediaItem.vue";

const props = defineProps<{
    title?: string;
    video: VideoData;
}>();

console.log(props.video, 'video item page')

const video = props.video

</script>

<style scoped></style>
