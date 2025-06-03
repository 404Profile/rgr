<template>
    <Head title="Новости" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ $t('admin.news') }}</h1>

            <div v-if="news.data && news.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="article in news.data" :key="article.id" class="flex flex-col overflow-hidden rounded-lg shadow-lg">
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
                                <p class="text-xl font-semibold text-gray-900">{{ article.title }}</p>
                                <p class="mt-3 text-base text-gray-500">{{ article.summary }}</p>
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
            <div v-else class="text-center py-12">
                <p class="text-gray-500">На данный момент новостей нет.</p>
            </div>

            <Pagination :links="news.links" class="mt-8" />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    news: Object
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ru-RU');
};
</script>
