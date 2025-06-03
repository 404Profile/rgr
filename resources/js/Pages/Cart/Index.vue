<template>
    <Head title="Корзина" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Корзина</h1>

            <div v-if="cart && cart.items && cart.items.length" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Товары в корзине -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            <li v-for="item in cart.items" :key="item.id" class="p-6">
                                <div class="flex flex-col sm:flex-row">
                                    <div class="flex-shrink-0 w-full sm:w-24 h-24 mb-4 sm:mb-0">
                                        <img
                                            :src="item.product.image ? `/storage/${item.product.image}` : '/images/placeholder.jpg'"
                                            :alt="item.product.name"
                                            class="w-full h-full object-cover rounded-md"
                                        >
                                    </div>
                                    <div class="sm:ml-6 flex-1">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="text-base font-medium text-gray-900">
                                                    <Link :href="route('product.show', item.product.slug)" class="hover:text-indigo-600">
                                                        {{ item.product.name }}
                                                    </Link>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-500">{{ formatCurrency(item.price) }}</p>
                                            </div>
                                            <div class="flex items-center">
                                                <button
                                                    @click="removeItem(item.id)"
                                                    class="text-gray-400 hover:text-red-500"
                                                    aria-label="Удалить"
                                                >
                                                    <TrashIcon class="h-5 w-5" />
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex justify-between items-center">
                                            <div class="flex items-center border border-gray-300 rounded-md">
                                                <button
                                                    @click="updateQuantity(item.id, item.quantity - 1)"
                                                    class="p-2 text-gray-600 hover:text-gray-900"
                                                    :disabled="item.quantity <= 1"
                                                    :class="{ 'opacity-50 cursor-not-allowed': item.quantity <= 1 }"
                                                >
                                                    <MinusIcon class="h-4 w-4" />
                                                </button>
                                                <input
                                                    type="number"
                                                    v-model="quantityInputs[item.id]"
                                                    min="1"
                                                    max="99"
                                                    class="w-12 text-center border-none focus:ring-0"
                                                    @blur="updateQuantity(item.id, parseInt(quantityInputs[item.id]))"
                                                    @keyup.enter="updateQuantity(item.id, parseInt(quantityInputs[item.id]))"
                                                />
                                                <button
                                                    @click="updateQuantity(item.id, item.quantity + 1)"
                                                    class="p-2 text-gray-600 hover:text-gray-900"
                                                >
                                                    <PlusIcon class="h-4 w-4" />
                                                </button>
                                            </div>
                                            <p class="text-base font-medium text-gray-900">{{ formatCurrency(item.price * item.quantity) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <Link
                            :href="route('catalog.index')"
                            class="flex items-center text-sm text-indigo-600 hover:text-indigo-500"
                        >
                            <ArrowLeftIcon class="h-4 w-4 mr-1" />
                            Продолжить покупки
                        </Link>
                        <button
                            @click="clearCart"
                            class="flex items-center text-sm text-red-600 hover:text-red-500"
                        >
                            <TrashIcon class="h-4 w-4 mr-1" />
                            Очистить корзину
                        </button>
                    </div>
                </div>

                <!-- Сводка заказа -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-md rounded-lg p-6 sticky top-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Сводка заказа</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Товары ({{ cart.items_count }})</p>
                                <p class="text-sm text-gray-900">{{ formatCurrency(cart.subtotal) }}</p>
                            </div>
                            <div v-if="cart.discount" class="flex justify-between">
                                <p class="text-sm text-gray-600">Скидка</p>
                                <p class="text-sm text-green-600">-{{ formatCurrency(cart.discount) }}</p>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <p class="font-medium">Итого</p>
                                    <p class="font-bold text-lg">{{ formatCurrency(cart.total) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div v-if="promoForm.success" class="mb-4 text-sm text-green-600">
                                {{ promoForm.success }}
                            </div>

                            <form @submit.prevent="applyPromo" class="mb-4">
                                <div class="flex space-x-2">
                                    <TextInput
                                        v-model="promoForm.code"
                                        type="text"
                                        placeholder="Промокод"
                                        class="flex-1"
                                    />
                                    <Button
                                        type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white"
                                        :disabled="promoForm.processing"
                                    >
                                        Применить
                                    </Button>
                                </div>
                                <InputError :message="promoForm.errors.code" class="mt-1" />
                            </form>

                            <Link
                                :href="route('checkout')"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Оформить заказ
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="bg-white shadow-md rounded-lg p-12 text-center">
                <div class="flex flex-col items-center">
                    <ShoppingCartIcon class="h-16 w-16 text-gray-400" />
                    <h2 class="mt-4 text-xl font-medium text-gray-900">Ваша корзина пуста</h2>
                    <p class="mt-2 text-gray-600">Добавьте товары в корзину, чтобы продолжить покупки</p>
                    <Link
                        :href="route('catalog.index')"
                        class="mt-6 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                    >
                        Перейти в каталог
                        <ArrowRightIcon class="ml-2 -mr-1 h-5 w-5" aria-hidden="true" />
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import {
    TrashIcon,
    PlusIcon,
    MinusIcon,
    ShoppingCartIcon,
    ArrowLeftIcon,
    ArrowRightIcon
} from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    cart: Object
});

const quantityInputs = ref({});

onMounted(() => {
    if (props.cart && props.cart.items) {
        props.cart.items.forEach(item => {
            quantityInputs.value[item.id] = item.quantity;
        });
    }
});

const promoForm = useForm({
    code: ''
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const updateQuantity = (itemId, quantity) => {
    if (quantity < 1) {
        quantity = 1;
    }

    quantityInputs.value[itemId] = quantity;

    router.patch(route('cart.update', itemId), {
        quantity: quantity
    }, {
        preserveScroll: true
    });
};

const removeItem = (itemId) => {
    router.delete(route('cart.remove', itemId), {
        preserveScroll: true
    });
};

const clearCart = () => {
    router.delete(route('cart.clear'), {
        preserveScroll: true
    });
};

const applyPromo = () => {
    promoForm.post(route('cart.promo'), {
        preserveScroll: true,
        onSuccess: () => {
            promoForm.code = '';
            promoForm.success = 'Промокод успешно применен!';
            setTimeout(() => {
                promoForm.success = null;
            }, 3000);
        }
    });
};
</script>
