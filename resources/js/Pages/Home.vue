<template>
    <Head title="Главная" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="relative">
            <div class="overflow-hidden">
                <div class="max-w-7xl mx-auto">
                    <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                        <svg
                            class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                            fill="currentColor"
                            viewBox="0 0 100 100"
                            preserveAspectRatio="none"
                            aria-hidden="true"
                        >
                            <polygon points="50,0 100,0 50,100 0,100" />
                        </svg>
                        <div class="pt-10 sm:pt-16 lg:pt-8 lg:pb-14 px-4 sm:px-6 lg:px-8">
                            <div class="text-center lg:text-left">
                                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                    <span class="block">Качественные товары</span>
                                    <span class="block text-indigo-600">по доступным ценам</span>
                                </h1>
                                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto lg:mx-0">
                                    Добро пожаловать в наш интернет-магазин! Мы предлагаем широкий ассортимент качественных товаров от ведущих производителей.
                                </p>
                                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                    <div class="rounded-md shadow">
                                        <Link :href="route('catalog.index')" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                            Перейти в каталог
                                        </Link>
                                    </div>
                                    <div class="mt-3 sm:mt-0 sm:ml-3">
                                        <Link :href="route('about')" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                            О нас
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                    <img
                        class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                        src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80"
                        alt=""
                    >
                </div>
            </div>
        </div>

        <!-- Популярные категории -->
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 text-center mb-8">
                Популярные категории
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="category in popularCategories" :key="category.id" class="group relative">
                    <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-200 overflow-hidden">
                        <img
                            :src="category.image ? `/storage/${category.image}` : '/images/placeholder.jpg'"
                            alt=""
                            class="object-center object-cover group-hover:opacity-75 transition-opacity"
                        >
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <Link :href="route('catalog.category', { slug: category.slug })">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ category.name_ru }}
                                </Link>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ category.products_count }} товаров</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <Link :href="route('catalog.index')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Все категории
                    <ArrowRightIcon class="ml-2 -mr-1 h-5 w-5" aria-hidden="true" />
                </Link>
            </div>
        </div>

        <!-- Популярные товары -->
        <div class="bg-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 text-center mb-8">
                    Популярные товары
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="product in featuredProducts" :key="product.id" class="group relative">
                        <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-200 overflow-hidden">
                            <img
                                :src="product.image ? `/storage/${product.image}` : '/images/placeholder.jpg'"
                                alt=""
                                class="object-center object-cover group-hover:opacity-75 transition-opacity"
                            >
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between">
                                <h3 class="text-sm text-gray-700">
                                    <Link :href="route('catalog.show', product.slug)">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ product.name_ru }}
                                    </Link>
                                </h3>
                                <p class="text-sm font-medium text-gray-900">{{ formatCurrency(product.price) }}</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{ product.category.name_ru }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-8">
                    <Link :href="route('catalog.index')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Перейти в каталог
                        <ArrowRightIcon class="ml-2 -mr-1 h-5 w-5" aria-hidden="true" />
                    </Link>
                </div>
            </div>
        </div>

        <!-- Преимущества -->
        <div class="bg-gray-50">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 text-center mb-8">
                    Почему выбирают нас
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="flex justify-center">
                            <TruckIcon class="h-12 w-12 text-indigo-600" />
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Быстрая доставка</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Доставляем ваши заказы в кратчайшие сроки по всей России.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="flex justify-center">
                            <ShieldCheckIcon class="h-12 w-12 text-indigo-600" />
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Гарантия качества</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Мы отвечаем за качество всех товаров, представленных в нашем магазине.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="flex justify-center">
                            <CreditCardIcon class="h-12 w-12 text-indigo-600" />
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Удобная оплата</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Разнообразные способы оплаты для вашего удобства.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Последние новости -->
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 text-center mb-8">
                Последние новости
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div v-for="article in latestNews" :key="article.id" class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                    <div class="flex-shrink-0">
                        <img
                            class="h-48 w-full object-cover"
                            :src="article.image ? `/storage/${article.image}` : '/images/placeholder.jpg'"
                            alt=""
                        >
                    </div>
                    <div class="flex flex-1 flex-col justify-between bg-white p-6">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-indigo-600">
                                <span>{{ formatDate(article.created_at) }}</span>
                            </p>
                            <Link :href="route('news.show', article.slug)" class="mt-2 block">
                                <p class="text-xl font-semibold text-gray-900">{{ article.title_ru }}</p>
                                <p class="mt-3 text-base text-gray-500 line-clamp-3">{{ article.summary_ru }}</p>
                            </Link>
                        </div>
                        <div class="mt-6">
                            <Link :href="route('news.show', article.slug)" class="text-base font-semibold text-indigo-600 hover:text-indigo-500">
                                Читать далее
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <Link :href="route('news.index')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Все новости
                    <ArrowRightIcon class="ml-2 -mr-1 h-5 w-5" aria-hidden="true" />
                </Link>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRightIcon,
    TruckIcon,
    ShieldCheckIcon,
    CreditCardIcon
} from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    popularCategories: Array,
    featuredProducts: Array,
    latestNews: Array
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ru-RU');
};
</script>
