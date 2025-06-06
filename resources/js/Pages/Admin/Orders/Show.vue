<template>
    <AdminLayout :title="`Просмотр заказа #${order.id}`">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Заказ #{{ order.id }}</h1>
                <div class="flex gap-2">
                    <Link :href="route('admin.orders.edit', order.id)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        {{ $t('admin.edit') }}
                    </Link>
                    <Link :href="route('admin.orders.index')" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        Назад к списку
                    </Link>
                </div>
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
                            <p class="text-sm text-gray-600">Способ доставки</p>
                            <p class="font-medium">{{ order.shipping_method || 'Не указан' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Информация о клиенте -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Информация о клиенте</h2>
                    <div v-if="order.user">
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Зарегистрированный пользователь</p>
                            <p class="font-medium">
                                <Link :href="route('admin.users.show', order.user.id)" class="text-indigo-600 hover:text-indigo-900">
                                    {{ order.user.name }}
                                </Link>
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ order.user.email }}</p>
                        </div>
                    </div>
                    <div v-else>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Гость</p>
                            <p class="font-medium">{{ order.full_name }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">{{ order.email }}</p>
                        </div>
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
                                            {{ item.product?.name || item.product_name || 'Товар удален' }}
                                        </div>
                                        <div v-if="item.product" class="text-sm text-gray-500">
                                            <Link :href="route('admin.products.show', item.product.id)" class="text-indigo-600 hover:text-indigo-900">
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
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import OrderStatusBadge from '@/Components/Admin/OrderStatusBadge.vue';

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
