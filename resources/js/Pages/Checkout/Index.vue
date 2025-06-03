<InputError :message="form.errors.last_name" class="mt-1" />
</div>
<div>
<InputLabel for="email" value="Email" />
<TextInput
    id="email"
    v-model="form.email"
    type="email"
    class="mt-1 block w-full"
    required
/>
<InputError :message="form.errors.email" class="mt-1" />
</div>
<div>
<InputLabel for="phone" value="Телефон" />
<TextInput
    id="phone"
    v-model="form.phone"
    type="tel"
    class="mt-1 block w-full"
    required
/>
<InputError :message="form.errors.phone" class="mt-1" />
</div>
</div>
</div>

<!-- Адрес доставки -->
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
<h2 class="text-lg font-medium text-gray-900 mb-4">Адрес доставки</h2>
<div class="grid grid-cols-1 gap-6">
    <div>
        <InputLabel for="address" value="Адрес" />
        <TextInput
            id="address"
            v-model="form.address"
            type="text"
            class="mt-1 block w-full"
            required
        />
        <InputError :message="form.errors.address" class="mt-1" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <InputLabel for="city" value="Город" />
            <TextInput
                id="city"
                v-model="form.city"
                type="text"
                class="mt-1 block w-full"
                required
            />
            <InputError :message="form.errors.city" class="mt-1" />
        </div>
        <div>
            <InputLabel for="postal_code" value="Почтовый индекс" />
            <TextInput
                id="postal_code"
                v-model="form.postal_code"
                type="text"
                class="mt-1 block w-full"
                required
            />
            <InputError :message="form.errors.postal_code" class="mt-1" />
        </div>
    </div>
</div>
</div>

<!-- Способ доставки -->
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
<h2 class="text-lg font-medium text-gray-900 mb-4">Способ доставки</h2>
<div class="space-y-4">
    <div v-for="option in shippingOptions" :key="option.id" class="flex items-center">
        <input
            :id="`shipping-${option.id}`"
            name="shipping_method"
            type="radio"
            :value="option.id"
            v-model="form.shipping_method"
            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
            required
        />
        <label :for="`shipping-${option.id}`" class="ml-3 block">
            <div class="text-sm font-medium text-gray-900">{{ option.name }}</div>
            <div class="text-sm text-gray-500">{{ option.description }}</div>
            <div class="text-sm font-medium text-gray-900">{{ formatCurrency(option.price) }}</div>
        </label>
    </div>
</div>
<InputError :message="form.errors.shipping_method" class="mt-1" />
</div>

<!-- Способ оплаты -->
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
<h2 class="text-lg font-medium text-gray-900 mb-4">Способ оплаты</h2>
<div class="space-y-4">
    <div v-for="option in paymentOptions" :key="option.id" class="flex items-center">
        <input
            :id="`payment-${option.id}`"
            name="payment_method"
            type="radio"
            :value="option.id"
            v-model="form.payment_method"
            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
            required
        />
        <label :for="`payment-${option.id}`" class="ml-3 block">
            <div class="text-sm font-medium text-gray-900">{{ option.name }}</div>
            <div class="text-sm text-gray-500">{{ option.description }}</div>
        </label>
    </div>
</div>
<InputError :message="form.errors.payment_method" class="mt-1" />
</div>

<!-- Комментарий к заказу -->
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
<h2 class="text-lg font-medium text-gray-900 mb-4">Комментарий к заказу</h2>
<div>
                <Textarea
                    id="notes"
                    v-model="form.notes"
                    class="mt-1 block w-full"
                    rows="3"
                    placeholder="Дополнительная информация для доставки или другие комментарии..."
                />
    <InputError :message="form.errors.notes" class="mt-1" />
</div>
</div>

<!-- Согласие с условиями -->
<div class="bg-white shadow-md rounded-lg p-6 mb-6">
<div class="flex items-start">
    <div class="flex items-center h-5">
        <input
            id="terms"
            name="terms"
            type="checkbox"
            v-model="form.terms"
            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
            required
        />
    </div>
    <div class="ml-3 text-sm">
        <label for="terms" class="font-medium text-gray-700">
            Я согласен с
            <Link :href="route('terms')" class="text-indigo-600 hover:text-indigo-500">
                условиями использования
            </Link>
            и
            <Link :href="route('privacy')" class="text-indigo-600 hover:text-indigo-500">
                политикой конфиденциальности
            </Link>
        </label>
    </div>
</div>
<InputError :message="form.errors.terms" class="mt-1" />
</div>
</form>
</div>

<!-- Сводка заказа -->
<div class="lg:col-span-1">
<div class="bg-white shadow-md rounded-lg p-6 sticky top-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Ваш заказ</h2>

    <div class="divide-y divide-gray-200">
        <div v-for="item in cart.items" :key="item.id" class="py-3 flex justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">{{ item.product.name }}</p>
                <p class="text-sm text-gray-500">{{ item.quantity }} x {{ formatCurrency(item.price) }}</p>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ formatCurrency(item.price * item.quantity) }}</p>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-4 mt-4">
        <div class="flex justify-between mb-2">
            <p class="text-sm text-gray-600">Подытог</p>
            <p class="text-sm font-medium text-gray-900">{{ formatCurrency(cart.subtotal) }}</p>
        </div>
        <div v-if="cart.discount" class="flex justify-between mb-2">
            <p class="text-sm text-gray-600">Скидка</p>
            <p class="text-sm font-medium text-green-600">-{{ formatCurrency(cart.discount) }}</p>
        </div>
        <div v-if="selectedShippingMethod" class="flex justify-between mb-2">
            <p class="text-sm text-gray-600">Доставка</p>
            <p class="text-sm font-medium text-gray-900">{{ formatCurrency(selectedShippingMethod.price) }}</p>
        </div>
        <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
            <p class="text-base font-medium text-gray-900">Итого</p>
            <p class="text-base font-bold text-gray-900">{{ formatCurrency(totalWithShipping) }}</p>
        </div>
    </div>

    <div class="mt-6">
        <button
            type="submit"
            @click="submitOrder"
            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            :disabled="form.processing"
        >
            <span v-if="!form.processing">Оформить заказ</span>
            <span v-else class="flex items-center">
                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Обработка...
                </span>
        </button>
        <div class="text-center mt-4">
            <Link
                :href="route('cart')"
                class="text-sm text-indigo-600 hover:text-indigo-500"
            >
                Вернуться в корзину
            </Link>
        </div>
    </div>
</div>
</div>
</div>
<div v-else class="bg-white shadow-md rounded-lg p-12 text-center">
<div class="flex flex-col items-center">
    <ShoppingCartIcon class="h-16 w-16 text-gray-400" />
    <h2 class="mt-4 text-xl font-medium text-gray-900">Ваша корзина пуста</h2>
    <p class="mt-2 text-gray-600">Добавьте товары в корзину, чтобы оформить заказ</p>
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
import { ref, computed } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ShoppingCartIcon, ArrowRightIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Textarea from '@/Components/Textarea.vue';

const props = defineProps({
    cart: Object,
    shippingOptions: {
        type: Array,
        default: () => [
            {
                id: 'standard',
                name: 'Стандартная доставка',
                description: 'Доставка в течение 3-5 рабочих дней',
                price: 300
            },
            {
                id: 'express',
                name: 'Экспресс доставка',
                description: 'Доставка в течение 1-2 рабочих дней',
                price: 600
            },
            {
                id: 'pickup',
                name: 'Самовывоз',
                description: 'Из пункта выдачи заказов',
                price: 0
            }
        ]
    },
    paymentOptions: {
        type: Array,
        default: () => [
            {
                id: 'card',
                name: 'Банковская карта',
                description: 'Оплата онлайн картой Visa, MasterCard, МИР'
            },
            {
                id: 'cash',
                name: 'Наличные',
                description: 'Оплата наличными при получении'
            }
        ]
    }
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    postal_code: '',
    shipping_method: 'standard',
    payment_method: '',
    notes: '',
    terms: false
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const selectedShippingMethod = computed(() => {
    return props.shippingOptions.find(option => option.id === form.shipping_method);
});

const totalWithShipping = computed(() => {
    const shippingCost = selectedShippingMethod.value ? selectedShippingMethod.value.price : 0;
    return props.cart ? props.cart.total + shippingCost : 0;
});

const submitOrder = () => {
    form.post(route('checkout.store'), {
        onSuccess: () => {
            router.visit(route('checkout.success'));
        }
    });
};
</script>
