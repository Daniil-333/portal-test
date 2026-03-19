<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white">
            {{ title }}
        </h2>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="forgot" method="POST" class="space-y-6">
                <div>
                    <div class="mt-2">
                        <InputText type="email"
                                   name="email"
                                   placeholder="Email адрес"
                                   v-model="formForgot.email"
                                   class="input"
                                   unstyled />
                        <Message v-if="formForgot.errors.email" severity="error" size="small" variant="simple" class="formErrorMsg">{{ formForgot.errors.email }}</Message>
                    </div>
                    <div class="flex justify-end">
                        <Link :href="route('login')" class="text-blue-500">Вернуться назад</Link>
                    </div>
                    <div v-if="status" class="text-green-500 text-sm mt-1">{{ status }}</div>
                </div>

                <div>
                    <Button type="submit"
                            :disabled="formForgot.processing"
                            label="Сбросить пароль"/>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { route } from "momentum-trail";
import { useFormWithCsrf } from "@/composables/useFormWithCsrf.ts";
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import Button from "primevue/button";

defineProps<{
    title: string,
    status?: string | null
}>();

const formForgot = useFormWithCsrf({
    email: '',
})

const forgot = () => {
    formForgot.post(route('password.email'), {
        onFinish: () => {
            formForgot.reset('email')
        },
    })
}

</script>

<style scoped></style>
