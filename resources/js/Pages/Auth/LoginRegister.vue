<template>
    <Head>
        <title>{{ title }}</title>
    </Head>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white">{{ title }}</h2>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="handleSubmit" action="#" method="POST" class="space-y-6">
                <div v-if="isRegister">
                    <div class="mt-2">
                        <InputText type="text"
                                   name="user_name"
                                   v-model="form.user_name"
                                   class="input"
                                   placeholder="Имя"

                        />
                        <Message v-if="form.errors.user_name" severity="error" size="small" variant="simple" class="formErrorMsg">{{ form.errors.user_name }}</Message>
                    </div>
                </div>

                <div>
                    <div class="mt-2">
                        <InputText type="email"
                                   name="email"
                                   v-model="form.email"
                                   class="input"
                                   placeholder="Email адрес"

                        />
                        <Message v-if="form.errors.email" severity="error" size="small" variant="simple" class="formErrorMsg">{{ form.errors.email }}</Message>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <div v-if="!isRegister" class="text-sm">
                            <Link :href="route('password.request')" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Забыли пароль?</Link>
                        </div>
                    </div>
                    <div class="mt-2">
                        <InputText type="password"
                                   name="password"
                                   v-model="form.password"
                                   class="input"
                                   placeholder="Пароль"

                        />
                        <Message v-if="form.errors.password" severity="error" size="small" variant="simple" class="formErrorMsg">{{ form.errors.password }}</Message>
                    </div>
                </div>

                <div v-if="isRegister">
                    <div class="mt-2">
                        <InputText type="password"
                                   name="password_confirmation"
                                   v-model="form.password_confirmation"
                                   class="input"
                                   placeholder="Повторите пароль"

                        />
                        <Message v-if="form.errors.password_confirmation" severity="error" size="small" variant="simple" class="formErrorMsg">{{ form.errors.password_confirmation }}</Message>
                    </div>
                </div>

                <Message v-if="form.errors.recaptcha_token" severity="error" size="small" variant="simple" class="formErrorMsg">{{ form.errors.recaptcha_token }}</Message>

                <div v-if="!isRegister" class="flex justify-end gap-2 txt-color">
                    <p>Нет аккаунта?</p>
                    <Link :href="route('register')" class="text-blue-500">Зарегистрироваться</Link>
                </div>

                <div v-else class="flex justify-end gap-2 txt-color">
                    <p>Есть аккаунт?</p>
                    <Link :href="route('login')" class="text-blue-500">Войти</Link>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:shadow-none dark:hover:bg-indigo-400 dark:focus-visible:outline-indigo-500">
                        {{ isRegister ? 'Зарегистрироваться' : 'Войти'}}
                    </button>
                </div>

                <div class="flex justify-end align-center gap-3">
                    <Checkbox v-model="form.remember" id="remember" binary />
                    <label for="remember" class="font-medium text-gray-900 leading-[1.3] dark:text-white">Запомнить меня</label>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted } from "vue";
import {Head, Link} from "@inertiajs/vue3";
import { route } from "momentum-trail";
import { useFormWithCsrf } from "@/composables/useFormWithCsrf";
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import Checkbox from 'primevue/checkbox';

declare global {
    interface Window {
        grecaptcha: {
            ready: (callback: () => void) => void;
            execute: (siteKey: undefined | null | string, options: { action: string }) => Promise<string>;
        };
    }
}

interface AuthFormData {
    email: string;
    password: string;
    user_name?: string;
    password_confirmation?: string;
    remember?: boolean;
    recaptcha_token?: string;
}

const props = defineProps<{
    title: string,
    isRegister?: boolean,
    recaptchaSiteKey?: string | null | undefined,
}>()


const form = useFormWithCsrf<AuthFormData>({
    email: '',
    password: '',
    user_name: '',
    password_confirmation: '',
    remember: true,
    recaptcha_token: ''
})

const handleSubmit = async () => {
    if (props.isRegister) {
        try {
            await _executeRecaptcha();
        } catch (error) {
            console.error('reCAPTCHA error:', error);
            // alert('Ошибка проверки reCAPTCHA. Попробуйте еще раз.');
            return;
        }
    }

    const data = props.isRegister
        ? {
            user_name: form.user_name,
            email: form.email,
            password: form.password,
            password_confirmation: form.password_confirmation,
            remember: form.remember,
            recaptcha_token: form.recaptcha_token
        }
        : {
            email: form.email,
            password: form.password,
            remember: form.remember
        };

    form.transform(() => data).post(
        route(props.isRegister ? 'register' : 'login')
    );
};

const _executeRecaptcha = async (): Promise<void> => {
    if (!props.isRegister || !props.recaptchaSiteKey) {
        return Promise.resolve();
    }

    if (!window.grecaptcha) {
        throw new Error('reCAPTCHA not loaded');
    }

    return new Promise((resolve, reject) => {
        window.grecaptcha.ready(async () => {
            try {
                form.recaptcha_token = await window.grecaptcha.execute(
                    props.recaptchaSiteKey,
                    {action: 'register'}
                );
                resolve();
            } catch (error) {
                reject(error);
            }
        });
    });
};

onMounted(() => {
    if (props.isRegister && props.recaptchaSiteKey) {
        const script = document.createElement('script');
        script.src = `https://www.google.com/recaptcha/api.js?render=${props.recaptchaSiteKey}`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }
});

</script>

<style scoped></style>
