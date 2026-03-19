<template>
    <Head>
        <title>{{ title }}</title>
    </Head>

    <h1 class="h1 text-center mb-5">Подтвердите ваш email адрес</h1>

    <p class="text-center">Ссылка для подтверждения была отправлена на ваш email. Если вы не получили письмо, нажмите кнопку ниже, чтобы отправить ещё раз.</p>

    <form @submit.prevent="handleSubmit" method="post" class="flex justify-center mt-6">
        <Button type="submit"
                :label="cooldown ? 'Отправлено. Подождите минуту' : 'Отправить повторно'"
                :loading="formVerify.processing"
                :disabled="formVerify.processing || cooldown"
        />
    </form>

    <div v-if="resent && cooldown" class="mt-4 text-green-600 text-center rounded">
        <p class="mb-2">✓ Письмо отправлено повторно! Проверьте вашу почту.</p>
        <p>Следующая отправка возможна не ранее, чем через 1 минуту.</p>
    </div>
</template>

<script setup lang="ts">
import { computed, ref, onUnmounted } from 'vue';
import { Head, usePage } from "@inertiajs/vue3";
import {route} from "momentum-trail";
import { useFormWithCsrf } from "@/composables/useFormWithCsrf";
import Button from "primevue/button";

defineProps<{
    title: string,
}>();

const resent = computed(() => usePage().flash?.resent);
const formVerify = useFormWithCsrf({});
const _data = {};
const cooldown = ref<boolean>(false);
const cooldownTimer = ref<number | null>(null);

const handleSubmit = (e: Event) => {
    formVerify.transform(() => _data).post(route('verification.send'), {
        onSuccess: () => {
            cooldown.value = true;
            cooldownTimer.value = window.setTimeout(() => {
                cooldown.value = false;
            }, 60000);
        },
        onError: () => {
            cooldown.value = false;
            if(typeof cooldownTimer.value === 'number') {
                clearTimeout(cooldownTimer.value);
            }
        }
    });
}

onUnmounted(() => {
    if (cooldownTimer.value) {
        clearTimeout(cooldownTimer.value);
    }
});

</script>

<style scoped></style>
