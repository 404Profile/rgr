<template>
    <Head :title="$t('catalog.title')" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Боковая панель с фильтрами -->
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-white shadow-md rounded-lg p-6 sticky top-6">
                        <h2 class="text-lg font-semibold mb-4">{{ $t('catalog.categories') }}</h2>
                        <ul class="space-y-2">
                            <li v-for="category in categories" :key="category.id">
                                <Link
                                    :href="route('catalog.category', { slug: category.slug })"
                                    :class="[
                    'block text-sm hover:text-indigo-600',
                    selectedCategory === category.slug ? 'text-indigo-600 font-medium' : 'text-gray-700'
                  ]"
                                >
                                    {{ category.name }}
                                    <span class="text-gray-400 ml-1">({{ category.products_count }})</span>
                                </Link>
                                <ul v-if="category.children && category.children.length" class="ml-4 mt-2 space-y-2">
                                    <li v-for="child in category.children" :key="child.id">
                                        <Link
                                            :href="route('catalog.category', { slug: child.slug })"
                                            :class="[
                        'block text-sm hover:text-indigo-600',
                        selectedCategory === child.slug ? 'text-indigo-600 font-medium' : 'text-gray-700'
                      ]"
                                        >
                                            {{ child.name }}
                                            <span class="text-gray-400 ml-1">({{ child.products_count }})</span>
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <div class="border-t border-gray-200 my-6"></div>

                        <h2 class="text-lg font-semibold mb-4">{{ $t('catalog.brands') }}</h2>
                        <div class="space-y-2">
                            <div v-for="brand in brands" :key="brand.id" class="flex items-center">
                                <input
                                    :id="`brand-${brand.id}`"
                                    type="checkbox"
                                    :checked="selectedBrands.includes(brand.id.toString())"
                                    @change="toggleBrand(brand.id.toString())"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                />
                                <label :for="`brand-${brand.id}`" class="ml-2 text-sm text-gray-700">
                                    {{ brand.name }}
                                    <span class="text-gray-400">({{ brand.products_count }})</span>
                                </label>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 my-6"></div>

                        <h2 class="text-lg font-semibold mb-4">{{ $t('catalog.price') }}</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="price_min" class="block text-sm text-gray-700">{{ $t('catalog.from') }}</label>
                                <TextInput
                                    id="price_min"
                                    v-model="filters.price_min"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full text-sm"
                                    @change="applyFilters"
                                />
                            </div>
                            <div>
                                <label for="price_max" class="block text-sm text-gray-700">{{ $t('catalog.to') }}</label>
                                <TextInput
                                    id="price_max"
                                    v-model="filters.price_max"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full text-sm"
                                    @change="applyFilters"
                                />
                            </div>
                        </div>

                        <div class="border-t border-gray-200 my-6"></div>

                        <button
                            @click="resetFilters"
                            class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            {{ $t('catalog.resetFilters') }}
                        </button>
                    </div>
                </div>

                <!-- Основной контент с товарами -->
                <div class="lg:flex-1">
                    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl font-semibold text-gray-900">
                                {{ currentCategory ? currentCategory.name : $t('catalog.allProducts') }}
                            </h1>
                            <div class="flex items-center">
                                <label for="sort" class="text-sm text-gray-700 mr-2">{{ $t('catalog.sortBy') }}</label>
                                <select
                                    id="sort"
                                    v-model="filters.sort"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                                    @change="applyFilters"
                                >
                                    <option value="newest">{{ $t('catalog.sort.newest') }}</option>
                                    <option value="price_asc">{{ $t('catalog.sort.priceAsc') }}</option>
                                    <option value="price_desc">{{ $t('catalog.sort.priceDesc') }}</option>
                                    <option value="name_asc">{{ $t('catalog.sort.nameAsc') }}</option>
                                    <option value="name_desc">{{ $t('catalog.sort.nameDesc') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div v-if="products.data.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="product in products.data" :key="product.id" class="bg-white shadow-md rounded-lg overflow-hidden">
                            <Link :href="route('catalog.show', product.slug)">
                            <div class="aspect-w-1 aspect-h-1 w-full">
                                    <img
                                        :src="product.image ? `/storage/${product.image}` : '/images/placeholder.jpg'"
                                        :alt="product.name"
                                        class="object-cover object-center w-full h-full"
                                    >
                                </div>
                            </Link>
                            <div class="p-4">
                                <div class="mb-2">
                                    <span class="text-xs text-gray-500">{{ product.category.name }}</span>
                                </div>
                                <Link :href="route('catalog.show', product.slug)" class="block">
                                    <h3 class="text-lg font-medium text-gray-900 hover:text-indigo-600">{{ product.name }}</h3>
                                </Link>
                                <div class="mt-2 flex justify-between items-center">
                                    <p class="text-xl font-bold text-gray-900">{{ formatCurrency(product.price) }}</p>
                                    <button
                                        @click="addToCart(product)"
                                        class="flex items-center justify-center p-2 rounded-full bg-indigo-600 text-white hover:bg-indigo-700"
                                        :aria-label="$t('catalog.addToCart')"
                                    >
                                        <ShoppingCartIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="bg-white shadow-md rounded-lg p-6 text-center">
                        <p class="text-gray-600">{{ $t('catalog.noProductsFound') }}</p>
                    </div>

                    <Pagination :links="products.links" class="mt-6" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ShoppingCartIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import Pagination from '@/Components/Pagination.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    products: Object,
    categories: Array,
    brands: Array,
    currentCategory: Object,
    selectedCategory: String,
    selectedBrands: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({
            price_min: '',
            price_max: '',
            sort: 'newest'
        })
    }
});

const filters = ref({
    price_min: props.filters.price_min || '',
    price_max: props.filters.price_max || '',
    sort: props.filters.sort || 'newest'
});

const selectedBrands = ref(props.selectedBrands || []);

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const applyFilters = () => {
    let query = {
        brands: selectedBrands.value,
        price_min: filters.value.price_min,
        price_max: filters.value.price_max,
        sort: filters.value.sort
    };

    Object.keys(query).forEach(key => {
        if (Array.isArray(query[key]) && query[key].length === 0) {
            delete query[key];
        } else if (query[key] === '' || query[key] === null) {
            delete query[key];
        }
    });

    router.visit(route('catalog.index'), {
        data: query,
        preserveState: true,
        preserveScroll: true,
        only: ['products', 'filters', 'selectedBrands']
    });
};


const toggleBrand = (brandId) => {
    if (selectedBrands.value.includes(brandId)) {
        selectedBrands.value = selectedBrands.value.filter(id => id !== brandId);
    } else {
        selectedBrands.value.push(brandId);
    }
    applyFilters();
};

const resetFilters = () => {
    filters.value = {
        price_min: '',
        price_max: '',
        sort: 'newest'
    };
    selectedBrands.value = [];

    router.visit(route('catalog.index'), {
        preserveState: false,
        only: ['products', 'filters', 'selectedBrands']
    });
};


const addToCart = (product) => {
    router.post(route('cart.add'), {
        product_id: product.id,
        quantity: 1
    }, {
        preserveScroll: true
    });
};
</script>
