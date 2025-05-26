<template>
    <AdminLayout title="Категории">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Категории</h1>
            <Link :href="route('admin.categories.create')" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Добавить категорию
            </Link>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div v-if="categories.data.length" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Изображение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Родительская категория</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="category in categories.data" :key="category.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ category.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img v-if="category.image" :src="getImageUrl(category.image)" class="h-10 w-10 object-cover rounded-md" alt="Category Image">
                            <div v-else class="h-10 w-10 bg-gray-200 rounded-md flex items-center justify-center text-gray-500">
                                <PhotoIcon class="h-6 w-6" />
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ category.name_ru }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ category.parent?.name_ru || '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ category.slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                <span :class="[
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                  category.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                ]">
                  {{ category.active ? 'Активна' : 'Неактивна' }}
                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <Link :href="route('admin.categories.edit', category.id)" class="text-indigo-600 hover:text-indigo-900">
                                    Редактировать
                                </Link>
                                <button @click="confirmDelete(category)" class="text-red-600 hover:text-red-900">
                                    Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="p-6 text-center text-gray-500">
                Нет категорий. <Link :href="route('admin.categories.create')" class="text-indigo-600 hover:text-indigo-900">Создать новую</Link>
            </div>
        </div>

        <Pagination :links="categories.links" class="mt-4" />

        <DeleteModal
            v-if="categoryToDelete"
            :open="!!categoryToDelete"
            :title="`Удалить категорию '${categoryToDelete.name_ru}'?`"
            :message="'Это действие нельзя отменить. Все связанные товары останутся без категории.'"
            @confirm="deleteCategory"
            @cancel="categoryToDelete = null"
        />
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { PhotoIcon } from '@heroicons/vue/24/outline';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    categories: Object
});

const categoryToDelete = ref(null);

const getImageUrl = (path) => {
    return `/storage/${path}`;
};

const confirmDelete = (category) => {
    categoryToDelete.value = category;
};

const deleteCategory = () => {
    router.delete(route('admin.categories.destroy', categoryToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            categoryToDelete.value = null;
        }
    });
};
</script>
