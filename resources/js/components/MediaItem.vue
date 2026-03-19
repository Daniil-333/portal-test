<template>
    <div class="relative">
        <Card :class="[{'max-w-xl mx-auto': !isCard}, 'h-full']">
            <template #header>
                <video v-if="isVideo" controls muted preload="metadata" class="rounded-t-lg">
                    <source :src="videoItem.file_path">
                </video>
                <img v-else-if="isImage" :src="videoItem.file_path" class="rounded-t-lg" alt="{{ videoItem.title }}">
            </template>
            <template #title v-if="isCard">{{ videoItem.title }}</template>
            <template #subtitle>{{ videoItem.short_desc }}</template>
            <template #content v-if="!isCard">
                <div v-html="videoItem.description"></div>
            </template>

            <template #footer v-if="!isCard">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="50%">
                                <Chip :label="videoItem?.category.title" />
                            </td>
                            <td width="50%">
                                <Accordion v-if="videoItem.tags.length">
                                    <AccordionPanel value="">
                                        <AccordionHeader>Тэги</AccordionHeader>
                                        <AccordionContent >
                                            <p v-for="tag in videoItem.tags" :key="tag.id" class="mb-2 text-gray-500 dark:text-gray-400">
                                                {{ tag.title }}
                                            </p>
                                        </AccordionContent>
                                    </AccordionPanel>
                                </Accordion>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
        </Card>
        <Link v-if="isCard" class="absolute inset-0" :href="route('home.video_item', videoItem.slug)" />
    </div>
</template>

<script setup lang="ts">
import { route } from 'momentum-trail';
import { Link } from "@inertiajs/vue3";
import Card from 'primevue/card';
import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionHeader from 'primevue/accordionheader';
import AccordionContent from 'primevue/accordioncontent';
import Chip from 'primevue/chip';
import type {VideoData} from "@/types";

const props = defineProps<{
    entity: VideoData;
    isCard?: boolean
}>();

const _extImage = ['jpg', 'png', 'jpeg', 'webp'];
const _extVideo = ['avi', 'mp4', 'mkv'];

const videoItem = props.entity;
const isImage = videoItem.file_name ? _extImage.some(ext => videoItem.file_name.includes(ext)) : null;
const isVideo = videoItem.file_name ? _extVideo.some(ext => videoItem.file_name.includes(ext)) : null;

</script>

<style scoped></style>
