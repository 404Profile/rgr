<template>
    <Head :title="page.title_ru" />

    <MainLayout>
        <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ page.title_ru }}</h1>

                <article class="prose prose-indigo prose-lg max-w-none">
                    <div v-if="page.content_ru" v-html="page.content_ru"></div>
                    <p v-else>Содержимое отсутствует.</p>
                </article>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    page: Object
});
</script>
