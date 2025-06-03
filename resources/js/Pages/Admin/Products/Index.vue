<template>
    <AdminLayout title="Товары">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Товары</h1>
            <Link :href="route('admin.products.create')" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Добавить товар
            </Link>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div v-if="products.data.length" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Изображение</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Категория</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Бренд</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Остаток</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="product in products.data" :key="product.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ product.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img v-if="product.image" :src="getImageUrl(product.image)" class="h-10 w-10 object-cover rounded-md" alt="Product Image">
                            <div v-else class="h-10 w-10 bg-gray-200 rounded-md flex items-center justify-center text-gray-500">
                                <PhotoIcon class="h-6 w-6" />
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ product.category?.name || '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ product.brand?.name || '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ formatCurrency(product.price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                <span :class="[
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                  product.quantity > 5 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                ]">
                  {{ product.quantity }}
                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                <span :class="[
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                  product.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                ]">
                  {{ product.active ? 'Активен' : 'Неактивен' }}
                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <Link :href="route('admin.products.edit', product.id)" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $t('admin.edit') }}
                                </Link>
                                <button @click="confirmDelete(product)" class="text-red-600 hover:text-red-900">
                                    {{ $t('admin.delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="p-6 text-center text-gray-500">
                Нет товаров. <Link :href="route('admin.products.create')" class="text-indigo-600 hover:text-indigo-900">Создать новый</Link>
            </div>
        </div>

        <Pagination :links="products.links" class="mt-4" />

        <DeleteModal
            v-if="productToDelete"
            :open="!!productToDelete"
            :title="`Удалить товар '${productToDelete.name}'?`"
            :message="'Это действие нельзя отменить.'"
            @confirm="deleteProduct"
            @cancel="productToDelete = null"
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
    products: Object
});

const productToDelete = ref(null);

const getImageUrl = (path) => {
    return `/storage/${path}`;
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const confirmDelete = (product) => {
    productToDelete.value = product;
};

const deleteProduct = () => {
    router.delete(route('admin.products.destroy', productToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            productToDelete.value = null;
        }
    });
};
</script>
