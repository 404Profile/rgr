<template>
    <Head title="Заказ успешно оформлен" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8 text-center">
                <div class="flex justify-center">
                    <div class="h-24 w-24 rounded-full bg-green-100 flex items-center justify-center">
                        <CheckIcon class="h-12 w-12 text-green-600" />
                    </div>
                </div>

                <h1 class="mt-6 text-2xl font-semibold text-gray-900">Заказ успешно оформлен!</h1>
                <p class="mt-2 text-gray-600">Спасибо за ваш заказ. Номер вашего заказа: #{{ order.id }}</p>

                <div class="mt-8 text-left border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Информация о заказе</h2>

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

                        <div class="divide-y divide-gray-200">
                            <div v-for="item in order.items" :key="item.id" class="py-3 flex justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ item.product.name }}</h4>
                                    <p class="text-sm text-gray-500">{{ item.quantity }} x {{ formatCurrency(item.price) }}</p>
                                </div>
                                <div class="text-sm font-medium text-gray-900 ml-4">
                                    {{ formatCurrency(item.price * item.quantity) }}
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Итого:</span>
                                <span class="text-base font-medium text-gray-900">{{ formatCurrency(order.total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-center space-x-4">
                    <Link
                        :href="route('catalog.index')"
                        class="inline-flex items-center justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none"
                    >
                        Вернуться в магазин
                    </Link>

                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('profile.orders')"
                        class="inline-flex items-center justify-center py-2 px-4 border border-indigo-600 rounded-md shadow-sm text-sm font-medium text-indigo-600 hover:bg-indigo-50 focus:outline-none"
                    >
                        Перейти к моим заказам
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { CheckIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    order: Object,
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};
</script>
