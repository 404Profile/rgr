<template>
    <Head :title="`Заказ #${order.id}`" />

    <MainLayout>
        <div class="max-w-5xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Заказ #{{ order.id }}</h1>
                <Link :href="route('orders')" class="text-indigo-600 hover:text-indigo-900">
                    Назад к списку заказов
                </Link>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Информация о заказе -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Информация о заказе</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Статус</p>
                            <OrderStatusBadge :status="order.status" class="mt-1" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Дата создания</p>
                            <p class="font-medium">{{ formatDate(order.created_at) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Сумма</p>
                            <p class="font-medium">{{ formatCurrency(order.total) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Способ оплаты</p>
                            <p class="font-medium">{{ order.payment_method || 'Не указан' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Статус оплаты</p>
                            <p class="font-medium">{{ order.is_paid ? 'Оплачен' : 'Ожидает оплаты' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Способ доставки</p>
                            <p class="font-medium">{{ order.shipping_method || 'Не указан' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Информация о доставке -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Информация о доставке</h2>
                    <div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Получатель</p>
                            <p class="font-medium">{{ order.full_name }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ order.email }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Телефон</p>
                            <p class="font-medium">{{ order.phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Адрес доставки</p>
                            <p class="font-medium">{{ order.address || 'Не указан' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Товары заказа -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Товары</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Товар</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кол-во</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Итого</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in order.items" :key="item.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div v-if="item.product?.image" class="flex-shrink-0 h-10 w-10">
                                        <img :src="getImageUrl(item.product.image)" class="h-10 w-10 object-cover rounded-md" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ item.product?.name_ru || item.product_name || 'Товар удален' }}
                                        </div>
                                        <div v-if="item.product" class="text-sm text-gray-500">
                                            <Link :href="route('product.show', item.product.slug)" class="text-indigo-600 hover:text-indigo-900">
                                                Просмотр товара
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ formatCurrency(item.price) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ item.quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ formatCurrency(item.price * item.quantity) }}
                            </td>
                        </tr>
                        </tbody>
                        <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-medium">Итого:</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold">
                                {{ formatCurrency(order.total) }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Комментарий к заказу -->
            <div v-if="order.notes" class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Комментарий к заказу</h2>
                <p class="text-gray-700">{{ order.notes }}</p>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import OrderStatusBadge from '@/Components/OrderStatusBadge.vue';

const props = defineProps({
    order: Object
});

const getImageUrl = (path) => {
    return `/storage/${path}`;
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('ru-RU');
};
</script>
