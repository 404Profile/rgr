<template>
    <Head title="Оформление заказа" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Оформление заказа</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Форма оформления заказа -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Контактная информация</h2>

                        <form @submit.prevent="submitOrder">
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700">Имя</label>
                                        <input
                                            id="first_name"
                                            v-model="form.first_name"
                                            type="text"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            required
                                        />
                                        <div v-if="errors.first_name" class="text-sm text-red-600 mt-1">{{ errors.first_name }}</div>
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700">Фамилия</label>
                                        <input
                                            id="last_name"
                                            v-model="form.last_name"
                                            type="text"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            required
                                        />
                                        <div v-if="errors.last_name" class="text-sm text-red-600 mt-1">{{ errors.last_name }}</div>
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required
                                    />
                                    <div v-if="errors.email" class="text-sm text-red-600 mt-1">{{ errors.email }}</div>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                                    <input
                                        id="phone"
                                        v-model="form.phone"
                                        type="tel"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required
                                    />
                                    <div v-if="errors.phone" class="text-sm text-red-600 mt-1">{{ errors.phone }}</div>
                                </div>

                                <div class="border-t border-gray-200 pt-6">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Способ доставки</h2>

                                    <div class="space-y-4 mb-6">
                                        <div class="flex items-center">
                                            <input
                                                id="delivery_method_delivery"
                                                v-model="form.delivery_method"
                                                type="radio"
                                                value="delivery"
                                                class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            />
                                            <label for="delivery_method_delivery" class="ml-3 block text-sm font-medium text-gray-700">
                                                Доставка
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input
                                                id="delivery_method_pickup"
                                                v-model="form.delivery_method"
                                                type="radio"
                                                value="pickup"
                                                class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            />
                                            <label for="delivery_method_pickup" class="ml-3 block text-sm font-medium text-gray-700">
                                                Самовывоз
                                            </label>
                                        </div>
                                        <div v-if="errors.delivery_method" class="text-sm text-red-600 mt-1">{{ errors.delivery_method }}</div>
                                    </div>

                                    <div v-if="form.delivery_method === 'delivery'">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Адрес доставки</h3>

                                        <div class="space-y-6">
                                            <div>
                                                <label for="address" class="block text-sm font-medium text-gray-700">Адрес</label>
                                                <input
                                                    id="address"
                                                    v-model="form.address"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    required
                                                />
                                                <div v-if="errors.address" class="text-sm text-red-600 mt-1">{{ errors.address }}</div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                                <div>
                                                    <label for="city" class="block text-sm font-medium text-gray-700">Город</label>
                                                    <input
                                                        id="city"
                                                        v-model="form.city"
                                                        type="text"
                                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                        required
                                                    />
                                                    <div v-if="errors.city" class="text-sm text-red-600 mt-1">{{ errors.city }}</div>
                                                </div>
                                                <div>
                                                    <label for="state" class="block text-sm font-medium text-gray-700">Область</label>
                                                    <input
                                                        id="state"
                                                        v-model="form.state"
                                                        type="text"
                                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                        required
                                                    />
                                                    <div v-if="errors.state" class="text-sm text-red-600 mt-1">{{ errors.state }}</div>
                                                </div>
                                                <div>
                                                    <label for="zip" class="block text-sm font-medium text-gray-700">Индекс</label>
                                                    <input
                                                        id="zip"
                                                        v-model="form.zip"
                                                        type="text"
                                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                        required
                                                    />
                                                    <div v-if="errors.zip" class="text-sm text-red-600 mt-1">{{ errors.zip }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-6">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Способ оплаты</h2>

                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <input
                                                id="payment_method_cash"
                                                v-model="form.payment_method"
                                                type="radio"
                                                value="cash"
                                                class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            />
                                            <label for="payment_method_cash" class="ml-3 block text-sm font-medium text-gray-700">
                                                Наличными при получении
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input
                                                id="payment_method_card"
                                                v-model="form.payment_method"
                                                type="radio"
                                                value="card"
                                                class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            />
                                            <label for="payment_method_card" class="ml-3 block text-sm font-medium text-gray-700">
                                                Банковской картой при получении
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input
                                                id="payment_method_online"
                                                v-model="form.payment_method"
                                                type="radio"
                                                value="online"
                                                class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            />
                                            <label for="payment_method_online" class="ml-3 block text-sm font-medium text-gray-700">
                                                Онлайн оплата
                                            </label>
                                        </div>
                                        <div v-if="errors.payment_method" class="text-sm text-red-600 mt-1">{{ errors.payment_method }}</div>
                                    </div>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Примечания к заказу</label>
                                    <textarea
                                        id="notes"
                                        v-model="form.notes"
                                        rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    ></textarea>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button
                                    type="submit"
                                    class="w-full py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    :disabled="processing"
                                >
                                    <span v-if="processing">Обработка...</span>
                                    <span v-else>Подтвердить заказ</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Сводка заказа -->
                <div>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 mb-6 sticky top-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ваш заказ</h2>

                        <div class="divide-y divide-gray-200">
                            <div v-for="item in cart.items" :key="item.id" class="py-3 flex justify-between">
                                <div class="flex-1">
                                    <div class="flex">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">{{ item.product.name }}</h3>
                                            <p class="text-sm text-gray-500">{{ item.quantity }} x {{ formatCurrency(item.product.price) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-900 ml-4">
                                    {{ formatCurrency(item.product.price * item.quantity) }}
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600">Подытог:</span>
                                <span class="text-sm font-medium text-gray-900">{{ formatCurrency(cart.total) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600">Доставка:</span>
                                <span class="text-sm font-medium text-gray-900">Бесплатно</span>
                            </div>
                            <div class="border-t border-gray-200 my-2"></div>
                            <div class="flex justify-between">
                                <span class="text-base font-medium text-gray-900">Итого:</span>
                                <span class="text-base font-medium text-gray-900">{{ formatCurrency(cart.total) }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <Link
                                :href="route('cart.index')"
                                class="text-sm text-indigo-600 hover:text-indigo-500"
                            >
                                &larr; Вернуться к корзине
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    cart: Object,
    errors: Object,
    user: Object,
});

const processing = ref(false);

const form = reactive({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    zip: '',
    delivery_method: 'delivery',
    payment_method: 'cash',
    notes: ''
});

onMounted(() => {
    // Если пользователь авторизован, заполняем форму его данными
    if (props.user) {
        form.first_name = props.user.name.split(' ')[0] || '';
        form.last_name = props.user.name.split(' ')[1] || '';
        form.email = props.user.email || '';
        form.phone = props.user.phone || '';
        form.address = props.user.address || '';
        form.city = props.user.city || '';
        form.state = props.user.state || '';
        form.zip = props.user.zip || '';
    }
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const submitOrder = () => {
    processing.value = true;

    router.post(route('orders.store'), form, {
        onSuccess: () => {
            processing.value = false;
        },
        onError: () => {
            processing.value = false;
        }
    });
};
</script>
