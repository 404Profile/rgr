<template>
    <Head title="О нас" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">О нашей компании</h1>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Мы стремимся предоставить нашим клиентам лучшие товары и сервис. Узнайте больше о нашей истории,
                    миссии и команде.
                </p>
            </div>

            <!-- История компании -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Наша история</h2>
                        <p class="text-gray-600 mb-4">
                            Наша компания была основана в 2010 году с целью предоставления качественных товаров по доступным ценам.
                            Мы начинали как небольшой магазин с ограниченным ассортиментом, но благодаря поддержке наших клиентов
                            и стремлению к совершенству, мы выросли в один из ведущих интернет-магазинов в нашей отрасли.
                        </p>
                        <p class="text-gray-600">
                            За годы работы мы установили прочные партнерские отношения с ведущими производителями, что позволяет
                            нам предлагать широкий ассортимент качественных товаров по конкурентоспособным ценам. Мы постоянно
                            расширяем наш каталог, чтобы удовлетворить растущие потребности наших клиентов.
                        </p>
                    </div>
                    <div class="bg-gray-200">
                        <img
                            src="https://images.unsplash.com/photo-1579389083078-4e7018379f7e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                            alt="История компании"
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>
            </div>

            <!-- Миссия и ценности -->
            <div class="bg-white shadow-md rounded-lg p-8 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Наша миссия и ценности</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="rounded-full bg-indigo-100 p-3 inline-flex items-center justify-center mb-4">
                            <SparklesIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Качество</h3>
                        <p class="text-gray-600">
                            Мы тщательно отбираем товары для нашего каталога, гарантируя высокое качество
                            и надежность каждого продукта.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="rounded-full bg-indigo-100 p-3 inline-flex items-center justify-center mb-4">
                            <UserGroupIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Клиентоориентированность</h3>
                        <p class="text-gray-600">
                            Мы ставим потребности клиентов на первое место и стремимся предоставить исключительный
                            уровень обслуживания.
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="rounded-full bg-indigo-100 p-3 inline-flex items-center justify-center mb-4">
                            <LightBulbIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Инновации</h3>
                        <p class="text-gray-600">
                            Мы постоянно ищем новые решения и улучшения, чтобы сделать процесс покупок
                            более удобным и приятным.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Наша команда -->
            <div class="bg-white shadow-md rounded-lg p-8 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Наша команда</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1557862921-37829c790f19?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=776&q=80"
                                alt="Иван Петров"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Иван Петров</h3>
                        <p class="text-gray-600">Генеральный директор</p>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                                alt="Анна Сидорова"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Анна Сидорова</h3>
                        <p class="text-gray-600">Операционный директор</p>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                                alt="Дмитрий Иванов"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Дмитрий Иванов</h3>
                        <p class="text-gray-600">Технический директор</p>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80"
                                alt="Елена Смирнова"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Елена Смирнова</h3>
                        <p class="text-gray-600">Руководитель отдела продаж</p>
                    </div>
                </div>
            </div>

            <!-- Почему выбирают нас -->
            <div class="bg-white shadow-md rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Почему выбирают нас</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Широкий ассортимент</h3>
                            <p class="mt-1 text-gray-600">
                                Тысячи товаров от ведущих производителей в одном месте для удобства выбора.
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Гарантия качества</h3>
                            <p class="mt-1 text-gray-600">
                                Мы работаем только с проверенными поставщиками и гарантируем качество каждого товара.
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Быстрая доставка</h3>
                            <p class="mt-1 text-gray-600">
                                Доставляем заказы в кратчайшие сроки по всей России и странам СНГ.
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Профессиональная поддержка</h3>
                            <p class="mt-1 text-gray-600">
                                Наши специалисты всегда готовы помочь с выбором товара и ответить на все вопросы.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { SparklesIcon, UserGroupIcon, LightBulbIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';
</script>
