<template>
    <AdminLayout :title="`Просмотр страницы: ${page.title}`">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">{{ page.title }}</h1>
                <div class="flex gap-2">
                    <Link :href="route('admin.pages.edit', page.id)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        {{ $t('admin.edit') }}
                    </Link>
                    <Link :href="route('admin.pages.index')" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        {{ $t('common.back') }}
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-lg font-semibold">Основная информация</h2>
                        <span :class="[
              'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
              page.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
            ]">
              {{ page.active ? 'Активна' : 'Неактивна' }}
            </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">ID</p>
                            <p class="font-medium">{{ page.id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Slug</p>
                            <p class="font-medium">{{ page.slug }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Заголовок (RU)</p>
                            <p class="font-medium">{{ page.title }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Дата создания</p>
                            <p class="font-medium">{{ formatDate(page.created_at) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Последнее обновление</p>
                            <p class="font-medium">{{ formatDate(page.updated_at) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Содержание</h2>
                    <div v-if="page.content" class="prose max-w-none" v-html="page.content"></div>
                    <div v-else class="text-gray-500">Содержание отсутствует</div>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Meta информация</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-medium mb-2">RU:</h3>
                            <div class="mb-2">
                                <p class="text-sm text-gray-600">Title</p>
                                <p class="font-medium">{{ page.meta_title || 'Не указан' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Description</p>
                                <p class="font-medium">{{ page.meta_description || 'Не указан' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    page: Object
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('ru-RU');
};
</script>
