<template>
    <Head :title="`Заказ #${order.id}`" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Заказ #{{ order.id }}</h1>
                <Link
                    :href="route('profile.orders')"
                    class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                >
                    Назад к заказам
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">{{ formatDate(order.created_at) }}</p>
                        </div>
                        <div>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                  :class="{
                                      'bg-green-100 text-green-800': order.status === 'completed',
                                      'bg-yellow-100 text-yellow-800': order.status === 'processing',
                                      'bg-gray-100 text-gray-800': order.status === 'pending',
                                      'bg-red-100 text-red-800': order.status === 'canceled'
                                  }">
                                {{ order.status_text }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 mb-2">Контактная информация</h3>
                                <p class="text-sm text-gray-600">{{ order.first_name }} {{ order.last_name }}</p>
                                <p class="text-sm text-gray-600">{{ order.email }}</p>
                                <p class="text-sm text-gray-600">{{ order.phone }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 mb-2">
                                    {{ order.delivery_method === 'pickup' ? 'Самовывоз' : 'Адрес доставки' }}
                                </h3>
                                <template v-if="order.delivery_method === 'delivery'">
                                    <p class="text-sm text-gray-600">{{ order.address }}</p>
                                    <p class="text-sm text-gray-600">{{ order.city }}, {{ order.state }}, {{ order.zip }}</p>
                                </template>
                                <template v-else>
                                    <p class="text-sm text-gray-600">Самовывоз из магазина</p>
                                </template>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Способ оплаты</h3>
                            <p class="text-sm text-gray-600">
                                {{
                                    order.payment_method === 'cash' ? 'Наличными при получении' :
                                        order.payment_method === 'card' ? 'Банковской картой при получении' :
                                            'Онлайн оплата'
                                }}
                            </p>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Заказанные товары</h3>

                            <div class="mt-6 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Товар
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Цена
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Количество
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Сумма
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="item in order.items" :key="item.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img
                                                        :src="item.product.image ? `/storage/${item.product.image}` : '/images/placeholder.jpg'"
                                                        :alt="item.product.name"
                                                        class="h-10 w-10 object-cover rounded-md"
                                                    />
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ item.product.name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Артикул: {{ item.product.sku || 'Н/Д' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatCurrency(item.price) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ item.quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatCurrency(item.price * item.quantity) }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="border-t border-gray-200 mt-6 pt-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-base font-medium text-gray-900">Итого:</span>
                                    <span class="text-base font-medium text-gray-900">{{ formatCurrency(order.total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    order: Object,
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
