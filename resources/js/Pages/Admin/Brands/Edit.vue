<template>
    <AdminLayout :title="`Редактирование бренда: ${brand.name}`">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-4 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Редактирование бренда: {{ brand.name }}</h1>
                    <Link :href="route('admin.brands.index')" class="text-indigo-600 hover:text-indigo-900">
                        Назад к списку
                    </Link>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <form @submit.prevent="submit" enctype="multipart/form-data">
                        <div class="mb-4">
                            <InputLabel for="name" value="Название" />
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
                            <InputLabel for="slug" value="Slug (опционально)" />
                            <TextInput
                                id="slug"
                                v-model="form.slug"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="slug"
                            />
                            <InputError :message="form.errors.slug" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="description" value="Описание" />
                            <Textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full"
                                rows="4"
                            />
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="logo" value="Логотип" />
                            <div v-if="brand.logo" class="mt-2 mb-2">
                                <img :src="`/storage/${brand.logo}`" alt="" class="h-20 object-contain">
                            </div>
                            <input
                                id="logo"
                                type="file"
                                @input="form.logo = $event.target.files[0]"
                                class="mt-1 block w-full"
                                accept="image/*"
                            />
                            <InputError :message="form.errors.logo" class="mt-2" />
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
                                Сохранить
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
import Textarea from '@/Components/Textarea.vue';

const props = defineProps({
    brand: Object,
});

const form = useForm({
    name: props.brand.name,
    slug: props.brand.slug,
    description: props.brand.description || '',
    logo: null,
    _method: 'PUT',
});

const submit = () => {
    form.post(route('admin.brands.update', props.brand.id), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('admin.brands.index'));
        },
    });
};

const cancel = () => {
    router.visit(route('admin.brands.index'));
};
</script>
