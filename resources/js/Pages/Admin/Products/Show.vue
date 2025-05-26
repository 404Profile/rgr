<template>
    <AdminLayout :title="`Просмотр товара: ${product.name_ru}`">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">{{ product.name_ru }}</h1>
                <div class="flex gap-2">
                    <Link :href="route('admin.products.edit', product.id)" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Редактировать
                    </Link>
                    <Link :href="route('admin.products.index')" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        Назад к списку
                    </Link>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">Основное изображение</h2>
                            <div v-if="product.image" class="border rounded-lg overflow-hidden bg-gray-50">
                                <img :src="getImageUrl(product.image)" class="w-full h-auto" alt="Product Image">
                            </div>
                            <div v-else class="border rounded-lg p-12 bg-gray-50 flex items-center justify-center text-gray-400">
                                <PhotoIcon class="h-12 w-12" />
                                <span class="ml-2">Нет изображения</span>
                            </div>
                        </div>

                        <div v-if="product.gallery && product.gallery.length" class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">Галерея</h2>
                            <div class="grid grid-cols-3 gap-2">
                                <div v-for="(image, index) in product.gallery" :key="index" class="border rounded-lg overflow-hidden bg-gray-50">
                                    <img :src="getImageUrl(image)" class="w-full h-auto" :alt="`Gallery Image ${index+1}`">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h2 class="text-sm font-medium text-gray-500">ID</h2>
                                <p>{{ product.id }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Slug</h2>
                                <p>{{ product.slug }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Название (RU)</h2>
                                <p>{{ product.name_ru }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Название (EN)</h2>
                                <p>{{ product.name_en }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Категория</h2>
                                <p>{{ product.category?.name_ru || '-' }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Бренд</h2>
                                <p>{{ product.brand?.name_ru || '-' }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Цена</h2>
                                <p>{{ formatCurrency(product.price) }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Количество</h2>
                                <p>{{ product.quantity }}</p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Статус</h2>
                                <p>
                  <span :class="[
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    product.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                  ]">
                    {{ product.active ? 'Активен' : 'Неактивен' }}
                  </span>
                                </p>
                            </div>

                            <div>
                                <h2 class="text-sm font-medium text-gray-500">Дата создания</h2>
                                <p>{{ formatDate(product.created_at) }}</p>
                            </div>
                        </div>

                        <div v-if="product.specifications && Object.keys(product.specifications).length" class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">Характеристики</h2>
                            <div class="border rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Характеристика</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Значение</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(value, name) in product.specifications" :key="name">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ value }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">Описание (RU)</h2>
                            <div v-if="product.description_ru" class="prose max-w-none border rounded-lg p-4 bg-gray-50" v-html="product.description_ru"></div>
                            <div v-else class="border rounded-lg p-4 bg-gray-50 text-gray-400">Описание отсутствует</div>
                        </div>

                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">Описание (EN)</h2>
                            <div v-if="product.description_en" class="prose max-w-none border rounded-lg p-4 bg-gray-50" v-html="product.description_en"></div>
                            <div v-else class="border rounded-lg p-4 bg-gray-50 text-gray-400">Описание отсутствует</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { PhotoIcon } from '@heroicons/vue/24/outline';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    product: Object
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
