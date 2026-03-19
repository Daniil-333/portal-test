<template>
    <Head>
        <title>{{ title }}</title>
    </Head>
    <h1 class="h1 title-page">{{ title }}</h1>

    <Card class="h-full">
        <template #header v-if="article.image_path">
            <img :src="article.image_path" class="rounded-t-lg" alt="{{ article.title }}">
        </template>
        <template #content>
            <div v-html="article.description"></div>
        </template>

        <template #footer>
            <div class="flex justify-between border-t-1 mt-4 py-4 pb-0">
                <p class="italic">Опубликовано: {{ cdate }}</p>
                <p v-if="article.read_time">Время прочтения: {{ article.read_time }} мин.</p>
            </div>
        </template>
    </Card>
</template>

<script setup lang="ts">
import type {ArticleData} from "@/types";
import {Head} from "@inertiajs/vue3";
import Card from "primevue/card";

const props = defineProps<{
    title: string,
    article: ArticleData,
}>();
const _date = new Date(props.article.created_at);
const cdate = new Intl.DateTimeFormat("ru-RU").format(_date)

</script>

<style scoped></style>
