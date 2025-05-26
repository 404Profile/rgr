<template>
    <Head title="Корзина" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Корзина</h1>
            </div>

            <div v-if="cart.items.length > 0">
                <!-- Содержимое корзины -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                    <div class="overflow-x-auto">
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
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="item in cart.items" :key="item.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img :src="item.product.image ? `/storage/${item.product.image}` : '/images/placeholder.jpg'"
                                                 :alt="item.product.name"
                                                 class="h-16 w-16 object-cover rounded-md"/>
                                        </div>
                                        <div class="ml-4">
                                            <Link :href="route('catalog.show', item.product.slug)" class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                                                {{ item.product.name }}
                                            </Link>
                                            <div class="text-xs text-gray-500">
                                                Артикул: {{ item.product.sku || 'Н/Д' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatCurrency(item.product.price) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center border rounded-md max-w-[120px]">
                                        <button
                                            type="button"
                                            @click="updateItemQuantity(item, item.quantity - 1)"
                                            class="p-2 text-gray-500 hover:text-gray-700"
                                            :disabled="item.quantity <= 1"
                                        >
                                            <MinusIcon class="h-4 w-4" />
                                        </button>
                                        <input
                                            type="number"
                                            min="1"
                                            :value="item.quantity"
                                            @change="(e) => updateItemQuantity(item, parseInt(e.target.value))"
                                            class="w-12 text-center border-0 focus:ring-0"
                                        />
                                        <button
                                            type="button"
                                            @click="updateItemQuantity(item, item.quantity + 1)"
                                            class="p-2 text-gray-500 hover:text-gray-700"
                                        >
                                            <PlusIcon class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatCurrency(item.product.price * item.quantity) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button
                                        @click="removeItem(item)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        <TrashIcon class="h-5 w-5" />
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Итоги заказа -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="md:col-span-2">
                        <div class="flex space-x-2">
                            <button
                                @click="clearCart"
                                class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                            >
                                Очистить корзину
                            </button>
                            <Link
                                :href="route('catalog.index')"
                                class="py-2 px-4 border border-indigo-600 rounded-md shadow-sm text-sm font-medium text-indigo-600 hover:bg-indigo-50 focus:outline-none"
                            >
                                Продолжить покупки
                            </Link>
                        </div>
                    </div>
                    <div>
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600">Подытог:</span>
                                <span class="text-sm font-medium text-gray-900">{{ formatCurrency(cart.total) }}</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="text-sm text-gray-600">Доставка:</span>
                                <span class="text-sm font-medium text-gray-900">Бесплатно</span>
                            </div>
                            <div class="border-t border-gray-200 my-2"></div>
                            <div class="flex justify-between mb-4">
                                <span class="text-base font-medium text-gray-900">Итого:</span>
                                <span class="text-base font-medium text-gray-900">{{ formatCurrency(cart.total) }}</span>
                            </div>
                            <Link
                                :href="route('checkout.index')"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none"
                            >
                                Оформить заказ
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="bg-white shadow-md rounded-lg p-12 text-center">
                <ShoppingCartIcon class="h-16 w-16 mx-auto text-gray-400" />
                <h2 class="text-xl font-medium text-gray-900 mt-4">Ваша корзина пуста</h2>
                <p class="text-gray-500 mt-2">Начните делать покупки, чтобы заполнить вашу корзину товарами</p>
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
import { Head, Link, router } from '@inertiajs/vue3';
import { MinusIcon, PlusIcon, ShoppingCartIcon, TrashIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    cart: Object
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const updateItemQuantity = (item, quantity) => {
    if (quantity < 1) {
        quantity = 1;
    }

    router.post(route('cart.update'), {
        product_id: item.product.id,
        quantity: quantity
    }, {
        preserveScroll: true
    });
};

const removeItem = (item) => {
    router.post(route('cart.remove'), {
        product_id: item.product.id
    }, {
        preserveScroll: true
    });
};

const clearCart = () => {
    router.post(route('cart.clear'), {}, {
        preserveScroll: true
    });
};
</script>
