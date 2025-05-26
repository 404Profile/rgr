<template>
    <AdminLayout title="Создание пользователя">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-4 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Создание пользователя</h1>
                    <Link :href="route('admin.users.index')" class="text-indigo-600 hover:text-indigo-900">
                        Назад к списку
                    </Link>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <InputLabel for="name" value="Имя" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autocomplete="name"
                            />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autocomplete="email"
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="role" value="Роль" />
                            <SelectInput
                                id="role"
                                v-model="form.role"
                                class="mt-1 block w-full"
                                required
                            >
                                <option value="user">Пользователь</option>
                                <option value="manager">Менеджер</option>
                                <option value="admin">Администратор</option>
                            </SelectInput>
                            <InputError :message="form.errors.role" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="password" value="Пароль" />
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="password_confirmation" value="Подтверждение пароля" />
                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                            <InputError :message="form.errors.password_confirmation" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Button
                                type="button"
                                class="mr-2"
                                :class="{ 'opacity-25': form.processing }"
                                @click="cancel"
                                :disabled="form.processing"
                            >
                                Отмена
                            </Button>
                            <Button
                                type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Создать
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';

const form = useForm({
    name: '',
    email: '',
    role: 'user',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            router.visit(route('admin.users.index'));
        },
    });
};

const cancel = () => {
    router.visit(route('admin.users.index'));
};
</script>
