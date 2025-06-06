<template>
    <Head :title="article.title" />

    <MainLayout>
        <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Хлебные крошки -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <Link :href="route('home')" class="text-gray-500 hover:text-gray-700">{{ $t('navigation.home') }}</Link>
                    </li>
                    <li>
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li>
                        <Link :href="route('news.index')" class="text-gray-500 hover:text-gray-700">{{ $t('navigation.news') }}</Link>
                    </li>
                    <li>
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-900 font-medium">{{ article.title }}</span>
                    </li>
                </ol>
            </nav>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div v-if="article.image" class="aspect-w-16 aspect-h-9">
                    <img
                        :src="`/storage/${article.image}`"
                        :alt="article.title"
                        class="w-full h-full object-cover object-center"
                    >
                </div>
                <div class="p-8">
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <CalendarIcon class="h-5 w-5 mr-1" />
                        <span>{{ formatDate(article.created_at) }}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ article.title }}</h1>

                    <article class="prose prose-indigo prose-lg max-w-none">
                        <div v-html="article.content"></div>
                    </article>

                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <Link :href="route('news.index')" class="flex items-center text-indigo-600 hover:text-indigo-500">
                                <ArrowLeftIcon class="h-5 w-5 mr-1" />
                                {{ $t('news.backToNews') }}
                            </Link>

                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Telegram</span>
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 11.944 0Zm.232 18.818c-.333 0-.678-.051-1.01-.154l-3.005.831.831-3.005a4.077 4.077 0 0 1-.154-1.01 4.075 4.075 0 0 1 4.075-4.075 4.075 4.075 0 0 1 4.075 4.075 4.076 4.076 0 0 1-4.812 3.338Zm0-7.767a3.692 3.692 0 0 0-3.688 3.688c0 .355.064.696.179 1.013l.108.289-.462 1.687 1.687-.462.289.108a3.68 3.68 0 0 0 1.013.179 3.691 3.691 0 0 0 3.688-3.688 3.69 3.69 0 0 0-3.688-3.688Zm2.11 4.7a.982.982 0 0 1-.132.149c-.174.174-.347.283-.521.283-.122 0-.248-.041-.423-.131l-.595-.298c-.5-.25-.988-.592-1.338-.942s-.692-.838-.942-1.338l-.298-.595c-.09-.175-.131-.301-.131-.423 0-.174.109-.347.283-.521a.982.982 0 0 1 .149-.132.707.707 0 0 1 .343-.089c.082 0 .165.025.232.075.075.05.138.125.189.206l.293.478c.066.111.078.211.037.3a.359.359 0 0 1-.066.115.518.518 0 0 1-.082.094 2.19 2.19 0 0 0-.18.206c-.05.066-.04.134.026.21.066.09.197.226.39.39s.3.325.39.39c.076.067.144.076.21.026.053-.03.135-.098.206-.18a.53.53 0 0 1 .094-.082.359.359 0 0 1 .115-.066c.089-.041.189-.029.3.037l.478.293c.081.05.156.114.206.19.05.066.075.149.075.231 0 .131-.03.242-.089.343Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Другие новости -->
            <div v-if="relatedArticles && relatedArticles.length" class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Другие новости</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="article in relatedArticles" :key="article.id" class="flex flex-col overflow-hidden rounded-lg shadow-lg">
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
                                    <p class="text-lg font-semibold text-gray-900">{{ article.title }}</p>
                                    <p class="mt-3 text-sm text-gray-500 line-clamp-3">{{ article.summary }}</p>
                                </Link>
                            </div>
                            <div class="mt-4">
                                <Link :href="route('news.show', article.slug)" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                                    Читать далее
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { CalendarIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline';

defineProps({
    article: Object
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ru-RU');
};
</script>
