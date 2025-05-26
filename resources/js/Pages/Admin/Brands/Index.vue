<template>
    <AdminLayout title="Бренды">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-4 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Бренды</h1>
                    <Link :href="route('admin.brands.create')" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Добавить бренд
                    </Link>
                </div>

                <!-- Сообщение об успехе -->
                <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                </div>

                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Логотип</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="brand in brands.data" :key="brand.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ brand.id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img v-if="brand.logo" :src="`/storage/${brand.logo}`" alt="" class="h-10 w-10 object-contain">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ brand.name_ru }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ brand.slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <Link :href="route('admin.brands.edit', brand.id)" class="text-indigo-600 hover:text-indigo-900">
                                        Редактировать
                                    </Link>
                                    <button @click="confirmDelete(brand.id)" class="text-red-600 hover:text-red-900">
                                        Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <Pagination :links="brands.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    brands: Object,
});

const confirmDelete = (id) => {
    if (confirm('Вы уверены, что хотите удалить этот бренд?')) {
        router.delete(route('admin.brands.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>
