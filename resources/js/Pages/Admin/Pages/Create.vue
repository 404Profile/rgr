<template>
    <AdminLayout title="Создание страницы">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Создание страницы</h1>
                <Link :href="route('admin.pages.index')" class="text-indigo-600 hover:text-indigo-900">
                    Назад к списку
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <InputLabel for="title_ru" value="Заголовок (RU)" />
                            <TextInput
                                id="title_ru"
                                v-model="form.title_ru"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.title_ru" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="title_en" value="Заголовок (EN)" />
                            <TextInput
                                id="title_en"
                                v-model="form.title_en"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.title_en" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <InputLabel for="slug" value="Slug (опционально)" />
                        <TextInput
                            id="slug"
                            v-model="form.slug"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <div class="mt-1 text-sm text-gray-500">
                            Если оставить пустым, будет сгенерирован автоматически
                        </div>
                        <InputError :message="form.errors.slug" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center">
                            <Checkbox id="active" v-model:checked="form.active" />
                            <InputLabel for="active" value="Активна" class="ml-2" />
                        </div>
                        <InputError :message="form.errors.active" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="content_ru" value="Содержание (RU)" />
                        <RichEditor
                            id="content_ru"
                            v-model="form.content_ru"
                            class="mt-1"
                        />
                        <InputError :message="form.errors.content_ru" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="content_en" value="Содержание (EN)" />
                        <RichEditor
                            id="content_en"
                            v-model="form.content_en"
                            class="mt-1"
                        />
                        <InputError :message="form.errors.content_en" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="meta_title_ru" value="Meta заголовок (RU)" />
                        <TextInput
                            id="meta_title_ru"
                            v-model="form.meta_title_ru"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.meta_title_ru" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="meta_description_ru" value="Meta описание (RU)" />
                        <Textarea
                            id="meta_description_ru"
                            v-model="form.meta_description_ru"
                            class="mt-1 block w-full"
                            rows="2"
                        />
                        <InputError :message="form.errors.meta_description_ru" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="meta_title_en" value="Meta заголовок (EN)" />
                        <TextInput
                            id="meta_title_en"
                            v-model="form.meta_title_en"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.meta_title_en" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="meta_description_en" value="Meta описание (EN)" />
                        <Textarea
                            id="meta_description_en"
                            v-model="form.meta_description_en"
                            class="mt-1 block w-full"
                            rows="2"
                        />
                        <InputError :message="form.errors.meta_description_en" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
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
    </AdminLayout>
</template>

<script setup>
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import RichEditor from '@/Components/RichEditor.vue';

const form = useForm({
    title_ru: '',
    title_en: '',
    slug: '',
    content_ru: '',
    content_en: '',
    meta_title_ru: '',
    meta_description_ru: '',
    meta_title_en: '',
    meta_description_en: '',
    active: true,
});

const submit = () => {
    form.post(route('admin.pages.store'), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('admin.pages.index'));
        }
    });
};

const cancel = () => {
    router.visit(route('admin.pages.index'));
};
</script>
