<template>
    <Breadcrumb :model="breadcrumbs" class="bg-transparent">
        <template #item="{ item, props }">
            <Link v-if="item.url && !item.current" :href="item.url" v-bind="props.action" custom>
                {{ item.title }}
            </Link>
            <span v-else v-bind="props.action" class="text-surface-700 dark:text-surface-0">{{ item.title }}</span>
        </template>
    </Breadcrumb>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import Breadcrumb from 'primevue/breadcrumb';

type PageType = {
    title: string,
    url?: string,
    current?: boolean,
}
const breadcrumbs = computed<PageType[]>(() => {
    const props = usePage().props;
    return (props.breadcrumbs as PageType[]) || [];
});


</script>

<style scoped></style>
