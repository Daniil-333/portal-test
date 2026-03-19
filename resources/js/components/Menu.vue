<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useMenu } from '@/composables/useMenu';
import {route} from "momentum-trail";

const { menuItems, isActive, activeClass } = useMenu();

</script>

<template>
    <Link
        v-for="item in menuItems"
        :key="item.routeName"
        :href="route(item.routeName as any)"
        class="rounded-md px-3 py-2 text-sm font-medium"
        :class="[
            isActive(item.routeName)
                ? activeClass
                : 'text-gray-300 hover:bg-white/5 hover:text-white'
        ]"
    >
        <span v-if="item.icon" class="mr-3">{{ item.icon }}</span>
        {{ item.label }}
    </Link>
</template>
