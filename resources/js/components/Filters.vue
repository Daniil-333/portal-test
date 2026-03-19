<template>
    <form action="#" class="mb-10 mt-10">

        <div class="md:flex items-center gap-4 grid">
            <IconField>
                <InputIcon>
                    <MagnifyingGlassIcon style="width: 16px;" />
                </InputIcon>
                <InputText v-model="filterStore.search" placeholder="Search" class="w-full" />
            </IconField>

            <Select v-model="filterStore.category"
                    :options="categories"
                    optionLabel="name"
                    optionValue="value"
                    placeholder="Выбрать категорию"
                    class="w-full md:w-56"
                    checkmark
                    showClear
            />

            <MultiSelect v-model="filterStore.tags"
                         :options="tags"
                         optionLabel="title"
                         optionValue="id"
                         filter
                         placeholder="Выберите тэги"
                         :maxSelectedLabels="0"
                         class="w-full md:w-80"
                         showClear
            />

            <Button label="Применить" severity="primary" @click="filterStore.applyFilters()" />
            <Button
                v-if="filterStore.hasActiveFilters"
                label="Сбросить"
                @click="filterStore.resetFilters"
                severity="secondary"
            />
        </div>

        <div class="grid items-center md:flex gap-4 mt-5">
            <Select v-model="filterStore.sortView"
                    :options="filterStore.sortViewOptions"
                    optionLabel="id"
                    optionValue="value"
                    @change="filterStore.clearSortBy"
                    placeholder="Сортировать по"
                    class="w-full md:w-56"
                    checkmark
                    showClear
            />
            <Select v-model="filterStore.sortBy"
                    :options="filterStore.sortByOptions"
                    optionLabel="id"
                    optionValue="value"
                    placeholder="Тип сортировки"
                    class="w-full md:w-56"
                    checkmark
                    showClear
                    :disabled="!filterStore.sortView"
            />
        </div>
    </form>
</template>

<script setup lang="ts">
import { useFilterStore } from '@/stores/filters';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import MultiSelect from 'primevue/multiselect';
import Button from 'primevue/button';
import { MagnifyingGlassIcon } from "@heroicons/vue/16/solid";
import type { TagData } from "@/types";

defineProps<{
    categories: {name: string, value: number}[];
    tags: TagData[];
}>();
const filterStore = useFilterStore();

</script>

<style scoped lang="scss"></style>
