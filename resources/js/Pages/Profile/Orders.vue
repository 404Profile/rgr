<template>
    <Head title="Мои заказы" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Мои заказы</h1>
            </div>

            <div v-if="orders.data.length > 0">
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        <li v-for="order in orders.data" :key="order.id">
                            <Link :href="route('profile.order', order.id)" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                Заказ #{{ order.id }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ formatDate(order.created_at) }}
                                            </p>
                                        </div>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                               :class="{
                                                   'bg-green-100 text-green-800': order.status === 'completed',
                                                   'bg-yellow-100 text-yellow-800': order.status === 'processing',
                                                   'bg-gray-100 text-gray-800': order.status === 'pending',
                                                   'bg-red-100 text-red-800': order.status === 'canceled'
                                               }">
                                                {{ order.status_text }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500">
                                                {{ order.items.length }} товаров
                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                            <p>
                                                {{ formatCurrency(order.total) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Пагинация -->
                <div class="mt-6">
                    <Pagination :links="orders.links" />
                </div>
            </div>
            <div v-else class="bg-white shadow rounded-lg p-12 text-center">
                <ShoppingBagIcon class="h-16 w-16 mx-auto text-gray-400" />
                <h2 class="text-xl font-medium text-gray-900 mt-4">У вас пока нет заказов</h2>
                <p class="text-gray-500 mt-2">Начните делать покупки, чтобы увидеть историю заказов</p>
                <div class="mt-6">
                    <Link
                        :href="route('catalog.index')"
                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none"
                    >
                        Перейти в каталог
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ShoppingBagIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    orders: Object,
});

const formatDate = (dateString) => {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('ru-RU', options);
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};
</script>
