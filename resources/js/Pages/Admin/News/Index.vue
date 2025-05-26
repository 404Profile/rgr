<template>
    <AdminLayout title="Управление новостями">
        <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Список новостей</h1>
                <Link
                    :href="route('admin.news.create')"
                    class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
                >
                    Добавить новость
                </Link>
            </div>

            <!-- Флеш-сообщение об успехе -->
            <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ $page.props.flash.success }}
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Изображение</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Заголовок</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата публикации</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="item in news.data" :key="item.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img v-if="item.image" :src="`/storage/${item.image}`" alt="" class="h-12 w-16 object-cover rounded">
                            <span v-else class="text-gray-400">Нет изображения</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ item.title_ru }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span :class="{
                                    'bg-blue-100 text-blue-800': item.type === 'news',
                                    'bg-purple-100 text-purple-800': item.type === 'promo'
                                }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    {{ getTypeLabel(item.type) }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span :class="{
                                    'bg-green-100 text-green-800': item.active,
                                    'bg-gray-100 text-gray-800': !item.active
                                }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    {{ item.active ? 'Активно' : 'Неактивно' }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ formatDate(item.published_at) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <Link :href="route('admin.news.edit', item.id)" class="text-indigo-600 hover:text-indigo-900">
                                    Редактировать
                                </Link>
                                <button @click="confirmDelete(item.id)" class="text-red-600 hover:text-red-900">
                                    Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <Pagination :links="news.links" />
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    news: Object,
});

const getTypeLabel = (type) => {
    const types = {
        'news': 'Новость',
        'promo': 'Акция',
    };
    return types[type] || type;
};

const formatDate = (dateString) => {
    if (!dateString) return 'Не указано';

    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const confirmDelete = (id) => {
    if (confirm('Вы уверены, что хотите удалить эту новость?')) {
        router.delete(route('admin.news.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>
