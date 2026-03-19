<template>
    <Head>
        <title>{{ title }}</title>
    </Head>
    <h1 class="h1">{{ title }}</h1>

    <div class="grid lg:grid-cols-3 items-start gap-5 mt-10">
        <Panel header="Информация" toggleable>
            <form @submit="handleInfo">
                <div class="grid gap-3 mb-5">
                    <label for="nickname">Имя</label>
                    <InputText id="nickname" type="text" v-model="nickname" placeholder="Имя" :value="$page.props?.auth.name" />
                </div>

                <div class="grid gap-3">
                    <label for="email">E-mail</label>
                    <InputText id="email" type="email" :value="$page.props?.auth.email" disabled />
                </div>

                <Button label="Обновить" type="submit" class="bg-green-500 text-white mt-5" />
            </form>
        </Panel>

        <Panel header="Пароль" toggleable collapsed>
            <p class="italic text-sm text-gray-400 mb-3">Убедитесь, что записали или запомнили новый пароль. После смены пароля произойдёт выход из личного кабинета.</p>

            <Form @submit="handlePassword"
                  :key="formPasswordKey"
                  v-slot="$form"
                  :resolver="resolverPassword"
                  :initialValues="initialValues"
                  class="mt-5"
            >
                <div class="flex flex-col gap-5">
                    <div class="grid gap-1">
                        <Password name="old" placeholder="Старый пароль" :feedback="false" toggleMask fluid />
                        <template v-if="$form.old?.invalid">
                            <Message v-for="(error, index) of $form.old.errors" :key="index" severity="error" size="small" variant="simple">{{ error.message }}</Message>
                        </template>
                    </div>

                    <div class="grid gap-1">
                        <Password name="new" placeholder="Новый пароль" :feedback="false" toggleMask fluid />
                        <template v-if="$form.new?.invalid">
                            <Message v-for="(error, index) of $form.new.errors" :key="index" severity="error" size="small"
                                     variant="simple">{{ error.message }}
                            </Message>
                        </template>
                    </div>

                    <div class="grid gap-1">
                        <Password name="confirm" placeholder="Подтвердите пароль" :feedback="false" toggleMask fluid/>
                        <template v-if="$form.confirm?.invalid">
                            <Message v-for="(error, index) of $form.confirm.errors" :key="index" severity="error" size="small"
                                     variant="simple">{{ error.message }}
                            </Message>
                        </template>
                    </div>
                </div>

                <Button label="Сменить" type="submit" class="bg-orange-500 text-white mt-5" />
            </Form>

        </Panel>

        <Panel header="Удаление аккаунта" toggleable collapsed >
            <p class="italic text-sm text-gray-400">После удаления вашей учетной записи все ее ресурсы и данные будут безвозвратно удалены. Перед удалением учетной записи, пожалуйста, загрузите все данные или информацию, которые вы хотите сохранить.</p>
            <Toast />
            <Button @click="removeAccount" label="Удалить" class="bg-red-500 text-white border-0 mt-3" />
        </Panel>
    </div>
</template>

<script setup lang="ts">
    import { ref } from "vue";
    import { Head, router } from "@inertiajs/vue3";
    import {Form, type FormSubmitEvent} from '@primevue/forms';
    import Password from "primevue/password";
    import Message from "primevue/message";
    import Panel from 'primevue/panel';
    import Button from "primevue/button";
    import { useToast } from 'primevue/usetoast';
    import Toast from 'primevue/toast';
    import InputText from 'primevue/inputtext';
    import { zodResolver } from '@primevue/forms/resolvers/zod';
    import { z } from 'zod';
    import {route} from "momentum-trail";
    import { useFormWithCsrf } from "@/composables/useFormWithCsrf";

    defineProps<{
        title: string,
        msg?: string
    }>();

    const toast = useToast();
    const initialValues = ref({
        old: '',
        new: '',
        confirm: '',
    });
    const nickname = ref<string>('');
    const formPasswordKey = ref(Date.now());

    const resolverPassword = ref(zodResolver(
        z.object({
            old: z.string(),
            new: z
                .string()
                .min(3, { message: 'Минимум 3 символа.' })
                .max(16, { message: 'Максимум 16 символов.' })
                .refine((value) => /[a-z]/.test(value), {
                    message: 'Должна быть буква в нижнем регистре.'
                })
                .refine((value) => /[A-Z]/.test(value), {
                    message: 'Должна быть буква в верхнем регистре.'
                })
                .refine((value) => /[0-9]/.test(value), {
                    message: 'Должна быть цифра.'
                }),
            confirm: z.string()
        }).refine(data => data.new === data.confirm, {
            message: 'Пароли не совпадают.',
            path: ['confirm']
        })
    ));

    const formRemove = useFormWithCsrf({});
    const formUpdatePswd = useFormWithCsrf({
        old_password: '',
        password: '',
        confirm: '',
    });
    const formUpdateInfo = useFormWithCsrf({
        nickname: ''
    })

    const handlePassword = (e: FormSubmitEvent) => {
        if(e.valid) {
            const currentUrl = window.location.href;
            formUpdatePswd.old_password = e.values.old;
            formUpdatePswd.password = e.values.new;
            formUpdatePswd.confirm = e.values.confirm;
            formUpdatePswd.post(route('profile.update_pswd'), {
                preserveState: true,
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Успешно', detail: 'Пароль успешно изменён!', life: 3000 });
                    formUpdatePswd.reset();
                    initialValues.value = {
                        old: '',
                        new: '',
                        confirm: ''
                    };
                    formPasswordKey.value = Date.now();
                },
                onError: (err) => {
                    toast.add({ severity: 'error', summary: 'Ошибка обновления пароля', detail: _modifyOutputErrors(err), life: 3000 });
                },
                onFinish: () => {
                    router.visit(currentUrl, { preserveState: true, replace: true })
                }
            });
        }
    }

    const handleInfo = (e: Event) => {
        e.preventDefault();
        const currentUrl = window.location.href;

        formUpdateInfo.post(route('profile.update_info'), {
            preserveState: true,
            onError: (err) => {
                toast.add({ severity: 'error', summary: 'Ошибка обновления', detail: _modifyOutputErrors(err), life: 3000 });
            },
            onFinish: () => {
                router.visit(currentUrl, { preserveState: true, replace: true })
            }
        })
    }

    const removeAccount = () => {
        formRemove.post(route('profile.remove'), {
            preserveState: true,
            onError: (err: Record<string, any>) => {
                toast.add({ severity: 'error', summary: 'Ошибка удаления', detail: _modifyOutputErrors(err), life: 3000 });
            }
        })
    }

    const _modifyOutputErrors = (error: Record<string, any>) => {
        let result = '';
        for (let err in error) {
            console.log(error[err]);
            const msg = error[err];

            if (typeof msg === 'string') {
                result += `${msg} \n`
            }
            else if (Array.isArray(msg)) {
                result += msg.join(',\n')
            }
        }

        return result;
    }

</script>

<style scoped></style>
