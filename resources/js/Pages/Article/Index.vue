<template>
    <Head>
        <title>{{ title }}</title>
    </Head>

    <h1 class="h1 title-page">{{ title }}</h1>

    <div v-if="articles.total > 0">
        <div class="grid md:grid-cols-3 gap-4">
            <div v-for="item in articleItems" :key="item.id" class="relative">
                <Card class="h-full">
                    <template #header v-if="item.image_path">
                        <img :src="item.image_path" class="rounded-t-lg" :alt="item.title">
                    </template>
                    <template #title>{{ item.title }}</template>
                    <template #content>
                        <div>{{ item.short_desc }}</div>
                    </template>

                    <template #footer></template>
                </Card>
                <Link class="absolute inset-0" :href="route('article.show', item.slug)" />
            </div>
        </div>
        <Paginator :first="first"
                   :rows="rows"
                   :totalRecords="totalRecords"
                   :alwaysShow="false"
                   @page="handlePaginate"
                   :template="{
                        '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                        '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                        default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink'
                    }"
                   class="mt-5"
        >
        </Paginator>
    </div>
    <div v-else>Нет данных</div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import type {ArticleData, PaginatorData} from "@/types";
import { route } from "momentum-trail";
import Card from "primevue/card";
import Paginator, {type PageState} from 'primevue/paginator';

const props = defineProps<{
    title: string,
    articles: PaginatorData,
}>();

const articleItems = computed(() => props.articles.data as ArticleData[]);

const first = computed(() => (props.articles.current_page - 1) * props.articles.per_page);
const rows = computed(() => props.articles.per_page);
const totalRecords = computed(() => props.articles.total);
const handlePaginate = (e: PageState) => {
    const newPage = Math.floor(e.first / e.rows) + 1;

    router.get(window.location.pathname, {
        page: newPage,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
}

</script>

<style scoped></style>
