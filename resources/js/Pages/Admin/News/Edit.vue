<template>
    <AdminLayout :title="`Редактирование новости: ${news.title}`">
        <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Редактирование новости: {{ news.title }}</h1>
                <Link :href="route('admin.news.index')" class="text-indigo-600 hover:text-indigo-900">
                    Назад к списку
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Заголовок (RU) -->
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

                        <!-- Slug -->
                        <div>
                            <InputLabel for="slug" value="Slug (URL)" />
                            <TextInput
                                id="slug"
                                v-model="form.slug"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.slug" class="mt-2" />
                        </div>

                        <!-- Тип -->
                        <div>
                            <InputLabel for="type" value="Тип" />
                            <SelectInput
                                id="type"
                                v-model="form.type"
                                class="mt-1 block w-full"
                                required
                            >
                                <option value="news">Новость</option>
                                <option value="promo">Акция</option>
                            </SelectInput>
                            <InputError :message="form.errors.type" class="mt-2" />
                        </div>

                        <!-- Активность -->
                        <div>
                            <div class="flex items-center mt-6">
                                <input
                                    id="active"
                                    v-model="form.active"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                />
                                <InputLabel for="active" value="Активно" class="ml-2" />
                            </div>
                            <InputError :message="form.errors.active" class="mt-2" />
                        </div>

                        <!-- Дата публикации -->
                        <div>
                            <InputLabel for="published_at" value="Дата публикации" />
                            <TextInput
                                id="published_at"
                                v-model="form.published_at"
                                type="datetime-local"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.published_at" class="mt-2" />
                        </div>

                        <!-- Изображение -->
                        <div class="md:col-span-2">
                            <InputLabel for="image" value="Изображение" />
                            <div v-if="news.image" class="mt-2 mb-2">
                                <img :src="`/storage/${news.image}`" alt="" class="h-40 object-contain rounded">
                            </div>
                            <input
                                id="image"
                                type="file"
                                @input="form.image = $event.target.files[0]"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                accept="image/*"
                            />
                            <InputError :message="form.errors.image" class="mt-2" />
                        </div>
                    </div>

                    <!-- Содержание (RU) -->
                    <div class="mt-6">
                        <InputLabel for="content" value="Содержание" />
                        <QuillEditor
                            id="content"
                            :content="form.content"
                            @update:content="form.content = $event"
                            theme="snow"
                            :options="editorOptions"
                            class="mt-1 block w-full"
                            style="height: 300px"
                            contentType="html"
                        />
                        <InputError :message="form.errors.content" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <Button
                            type="button"
                            class="mr-3"
                            @click="cancel"
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
import { watch, ref } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Button from '@/Components/Button.vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    news: Object,
});

const editorOptions = {
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['clean'],
            ['link', 'image']
        ],
    },
    placeholder: 'Введите содержание...',
};

// Форматирование даты для input type="datetime-local"
const formatDateForInput = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toISOString().slice(0, 16);
};

// Форма для редактирования новости
const form = useForm({
    title: props.news.title,
    slug: props.news.slug,
    content: props.news.content,
    image: null,
    type: props.news.type,
    published_at: formatDateForInput(props.news.published_at),
    active: Boolean(props.news.active),
    _method: 'PUT',
});

const submit = () => {
    form.post(route('admin.news.update', props.news.id), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('admin.news.index'));
        },
    });
};

const cancel = () => {
    router.visit(route('admin.news.index'));
};
</script>
