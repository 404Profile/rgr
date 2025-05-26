<template>
    <AdminLayout title="Заказы">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Заказы</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div v-if="orders.data.length" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">№</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Сумма</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="order in orders.data" :key="order.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ order.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ order.user?.name || order.full_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ formatCurrency(order.total) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <OrderStatusBadge :status="order.status" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(order.created_at) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <Link :href="route('admin.orders.show', order.id)" class="text-indigo-600 hover:text-indigo-900">
                                    Просмотр
                                </Link>
                                <Link :href="route('admin.orders.edit', order.id)" class="text-indigo-600 hover:text-indigo-900">
                                    Редактировать
                                </Link>
                                <button @click="confirmDelete(order)" class="text-red-600 hover:text-red-900">
                                    Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="p-6 text-center text-gray-500">
                Нет заказов
            </div>
        </div>

        <Pagination :links="orders.links" class="mt-4" />

        <DeleteModal
            v-if="orderToDelete"
            :open="!!orderToDelete"
            :title="`Удалить заказ №${orderToDelete.id}?`"
            :message="'Это действие нельзя отменить.'"
            @confirm="deleteOrder"
            @cancel="orderToDelete = null"
        />
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import OrderStatusBadge from '@/Components/Admin/OrderStatusBadge.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    orders: Object
});

const orderToDelete = ref(null);

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('ru-RU');
};

const confirmDelete = (order) => {
    orderToDelete.value = order;
};

const deleteOrder = () => {
    router.delete(route('admin.orders.destroy', orderToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            orderToDelete.value = null;
        }
    });
};
</script>
