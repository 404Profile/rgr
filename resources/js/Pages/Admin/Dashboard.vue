<template>
    <AdminLayout title="Панель управления">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <StatCard title="Общие продажи" :value="formatCurrency(stats.totalSales)" icon="currency-ruble" color="bg-blue-500" />
            <StatCard title="Заказов" :value="stats.totalOrders" icon="shopping-bag" color="bg-green-500" />
            <StatCard title="Ожидающие заказы" :value="stats.pendingOrders" icon="clock" color="bg-yellow-500" />
            <StatCard title="Товаров" :value="stats.totalProducts" icon="archive-box" color="bg-purple-500" />
            <StatCard title="Пользователей" :value="stats.totalUsers" icon="users" color="bg-indigo-500" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Последние заказы</h2>
                <div v-if="latestOrders.length" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="order in latestOrders" :key="order.id">
                            <td class="px-4 py-3 whitespace-nowrap">{{ order.id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ order.user?.name || order.full_name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ formatCurrency(order.total) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <OrderStatusBadge :status="order.status" />
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <Link :href="route('admin.orders.show', order.id)" class="text-indigo-600 hover:text-indigo-900">
                                    Просмотр
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-center py-4 text-gray-500">Нет заказов</div>
                <div class="mt-4">
                    <Link :href="route('admin.orders.index')" class="text-indigo-600 hover:text-indigo-900">
                        Все заказы →
                    </Link>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Товары с низким запасом</h2>
                <div v-if="lowStockProducts.length" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Товар</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Остаток</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="product in lowStockProducts" :key="product.id">
                            <td class="px-4 py-3 whitespace-nowrap">{{ product.name_ru }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    {{ product.quantity }}
                  </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ formatCurrency(product.price) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <Link :href="route('admin.products.edit', product.id)" class="text-indigo-600 hover:text-indigo-900">
                                    Редактировать
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-center py-4 text-gray-500">Все товары в достаточном количестве</div>
                <div class="mt-4">
                    <Link :href="route('admin.products.index')" class="text-indigo-600 hover:text-indigo-900">
                        Все товары →
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import StatCard from '@/Components/Admin/StatCard.vue';
import OrderStatusBadge from '@/Components/Admin/OrderStatusBadge.vue';

defineProps({
    stats: Object,
    latestOrders: Array,
    lowStockProducts: Array
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
}
</script>
