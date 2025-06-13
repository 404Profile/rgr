<template>
    <Head :title="page.title" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ page.title }}</h1>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-12">
                <div class="prose max-w-none" v-html="page.content"></div>
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
