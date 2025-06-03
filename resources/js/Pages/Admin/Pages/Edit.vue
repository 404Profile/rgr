<template>
    <AdminLayout title="Редактирование страницы">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Редактирование страницы</h1>
                <Link :href="route('admin.pages.index')" class="text-indigo-600 hover:text-indigo-900">
                    Назад к списку
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <InputLabel for="title" value="Заголовок" />
                            <TextInput
                                id="title"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <InputLabel for="slug" value="Slug" />
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
                        <InputLabel for="content" value="Содержание" />
                        <RichEditor
                            id="content"
                            v-model="form.content"
                            class="mt-1"
                        />
                        <InputError :message="form.errors.content" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="meta_title" value="Meta заголовок" />
                        <TextInput
                            id="meta_title"
                            v-model="form.meta_title"
                            type="text"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.meta_title" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="meta_description" value="Meta описание" />
                        <Textarea
                            id="meta_description"
                            v-model="form.meta_description"
                            class="mt-1 block w-full"
                            rows="2"
                        />
                        <InputError :message="form.errors.meta_description" class="mt-2" />
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
                            Сохранить
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

const props = defineProps({
    page: Object
});

const form = useForm({
    title: props.page.title,
    slug: props.page.slug,
    content: props.page.content || '',
    meta_title: props.page.meta_title || '',
    meta_description: props.page.meta_description || '',
    active: props.page.active,
    _method: 'PUT'
});

const submit = () => {
    form.post(route('admin.pages.update', props.page.id), {
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
