<template>
    <Head :title="product.name" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                    <!-- Изображение товара -->
                    <div>
                        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-lg overflow-hidden">
                            <img
                                :src="product.image ? `/storage/${product.image}` : '/images/placeholder.jpg'"
                                :alt="product.name"
                                class="object-cover object-center w-full h-full"
                            >
                        </div>
                        <div v-if="product.gallery && product.gallery.length" class="mt-4 grid grid-cols-4 gap-2">
                            <div
                                v-for="(image, index) in product.gallery"
                                :key="index"
                                class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden cursor-pointer"
                            >
                                <img
                                    :src="`/storage/${image}`"
                                    :alt="`${product.name} - изображение ${index + 1}`"
                                    class="object-cover object-center w-full h-full"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Информация о товаре -->
                    <div>
                        <div class="mb-2">
                            <Link :href="route('catalog.category', product.category.slug)" class="text-sm text-indigo-600 hover:text-indigo-800">
                                {{ product.category.name }}
                            </Link>
                            <span class="text-sm text-gray-400 mx-2">/</span>
                            <Link :href="route('catalog.brand', product.brand.slug)" class="text-sm text-indigo-600 hover:text-indigo-800">
                                {{ product.brand.name }}
                            </Link>
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $i18n.locale === 'en' && product.name_en ? product.name_en : product.name }}
                        </h1>

                        <div class="flex items-center space-x-4 mb-6">
                            <span class="text-3xl font-bold text-gray-900">{{ formatCurrency(product.price) }}</span>
                            <span v-if="product.quantity > 0" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                В наличии
                            </span>
                            <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Нет в наличии
                            </span>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center">
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mr-4">
                                    {{ $t('catalog.quantity') }}:
                                </label>
                                <div class="flex items-center border rounded-md">
                                    <button
                                        type="button"
                                        @click="decrementQuantity"
                                        class="p-2 text-gray-500 hover:text-gray-700"
                                        :disabled="quantity <= 1"
                                    >
                                        <MinusIcon class="h-4 w-4" />
                                    </button>
                                    <input
                                        id="quantity"
                                        v-model.number="quantity"
                                        type="number"
                                        min="1"
                                        :max="product.quantity"
                                        class="w-12 text-center border-0 focus:ring-0"
                                    />
                                    <button
                                        type="button"
                                        @click="incrementQuantity"
                                        class="p-2 text-gray-500 hover:text-gray-700"
                                        :disabled="quantity >= product.quantity"
                                    >
                                        <PlusIcon class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <button
                                @click="addToCart"
                                class="w-full flex items-center justify-center py-3 px-8 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :disabled="product.quantity <= 0"
                            >
                                <ShoppingCartIcon class="h-5 w-5 mr-2" />
                                {{ $t('catalog.addToCart') }}
                            </button>
                        </div>

                        <div class="prose prose-sm text-gray-700 mb-6">
                            <div v-if="$i18n.locale === 'en' && product.description_en" v-html="product.description_en" />
                            <div v-else v-html="product.description" />
                        </div>

                        <div v-if="product.specifications" class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                {{ $t('catalog.specifications') }}
                            </h3>
                            <dl class="grid grid-cols-1 gap-y-4">
                                <div v-for="(value, key) in product.specifications" :key="key" class="grid grid-cols-3 gap-4">
                                    <dt class="text-sm font-medium text-gray-500">{{ key }}</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">{{ value }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Похожие товары -->
            <div v-if="relatedProducts.length" class="mt-12">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ $t('catalog.specifications') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="relatedProduct in relatedProducts" :key="relatedProduct.id" class="bg-white shadow-md rounded-lg overflow-hidden">
                        <Link :href="route('catalog.show', relatedProduct.slug)">
                            <div class="aspect-w-1 aspect-h-1 w-full">
                                <img
                                    :src="relatedProduct.image ? `/storage/${relatedProduct.image}` : '/images/placeholder.jpg'"
                                    :alt="relatedProduct.name"
                                    class="object-cover object-center w-full h-full"
                                >
                            </div>
                        </Link>
                        <div class="p-4">
                            <div class="mb-2">
                                <span class="text-xs text-gray-500">{{ relatedProduct?.category?.name }}</span>
                            </div>
                            <Link :href="route('catalog.show', relatedProduct.slug)" class="block">
                                <h3 class="text-lg font-medium text-gray-900 hover:text-indigo-600">
                                    {{ $i18n.locale === 'en' && relatedProduct?.name_en ? relatedProduct?.name_en : relatedProduct?.name }}
                                </h3>
                            </Link>
                            <div class="mt-2 flex justify-between items-center">
                                <p class="text-xl font-bold text-gray-900">{{ formatCurrency(relatedProduct.price) }}</p>
                                <button
                                    @click="addRelatedToCart(relatedProduct)"
                                    class="flex items-center justify-center p-2 rounded-full bg-indigo-600 text-white hover:bg-indigo-700"
                                    aria-label="Добавить в корзину"
                                >
                                    <ShoppingCartIcon class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ShoppingCartIcon, MinusIcon, PlusIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';
import {useI18n} from "vue-i18n";

const props = defineProps({
    product: Object,
    relatedProducts: Array,
});

const quantity = ref(1);

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const incrementQuantity = () => {
    if (quantity.value < props.product.quantity) {
        quantity.value++;
    }
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const addToCart = () => {
    router.post(route('cart.add'), {
        product_id: props.product.id,
        quantity: quantity.value
    }, {
        preserveScroll: true
    });
};

const addRelatedToCart = (product) => {
    router.post(route('cart.add'), {
        product_id: product.id,
        quantity: 1
    }, {
        preserveScroll: true
    });
};

const { t, locale } = useI18n();
</script>
