<template>
    <Head>
        <title>{{ title }}</title>
    </Head>
    <h1 class="h1">{{ title }}</h1>

    <p class="mt-5">Стартовый шаблон для разработки.</p>

</template>

<script setup lang="ts">
import { Head } from "@inertiajs/vue3";

    defineProps<{
        title: string,
    }>();

</script>

<style scoped></style>
