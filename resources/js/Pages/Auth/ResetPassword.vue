<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white">{{ title }}</h2>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="reset" method="POST" class="space-y-6">
                <input type="hidden" name="token" :value="token">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Email адрес</label>
                    <div class="mt-2">
                        <InputText type="email"
                                   name="email"
                                   v-model="formReset.email"
                                   class="input"
                                   required
                        />
                        <Message v-if="formReset.errors.email" severity="error" size="small" variant="simple" class="formErrorMsg">{{ formReset.errors.email }}</Message>

                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Новый пароль</label>
                    <div class="mt-2">
                        <InputText type="password"
                                   name="password"
                                   v-model="formReset.password"
                                   class="input"
                                   placeholder="Пароль"

                        />
                        <Message v-if="formReset.errors.password" severity="error" size="small" variant="simple" class="formErrorMsg">{{ formReset.errors.password }}</Message>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Повторите пароль</label>
                    <div class="mt-2">
                        <InputText type="password"
                                   name="password_confirmation"
                                   v-model="formReset.password_confirmation"
                                   class="input"
                                   placeholder="Повторите пароль"

                        />
                        <Message v-if="formReset.errors.password_confirmation" severity="error" size="small" variant="simple" class="formErrorMsg">{{ formReset.errors.password_confirmation }}</Message>
                    </div>
                </div>

                <div v-if="status" class="text-green-500 text-sm mt-1">{{ status }}</div>

                <div>
                    <Button
                        type="submit"
                        :disabled="formReset.processing"
                        label="Изменить пароль" />
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useFormWithCsrf } from "@/composables/useFormWithCsrf.ts";
import { route } from "momentum-trail";
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import Button from "primevue/button";

const props = defineProps<{
    title: string,
    token: string,
    email: string,
    status: string | null
}>();

const formReset = useFormWithCsrf({
    token: props.token,
    email: props.email || '',
    password: '',
    password_confirmation: '',
})

const reset = () => {
    formReset.post(route('password.update'), {
        onFinish: () => {
            formReset.reset('password', 'password_confirmation')
        },
    })
}

</script>

<style scoped></style>
