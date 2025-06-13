<template>
    <Head :title="$t('pages.title')" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ $t('pages.title') }}</h1>
            </div>

            <div v-if="pages.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="page in pages" :key="page.id" class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">
                            <Link :href="route('pages.show', page.slug)" class="hover:text-indigo-600">
                                {{ page.title }}
                            </Link>
                        </h2>
                        <div class="text-gray-600 mb-4 line-clamp-3" v-html="page.content"></div>
                        <Link
                            :href="route('pages.show', page.slug)"
                            class="text-indigo-600 hover:text-indigo-800 font-medium"
                        >
                            {{ $t('pages.readMore') }}
                        </Link>
                    </div>
                </div>
            </div>
            <div v-else class="text-center py-12">
                <p class="text-gray-500">{{ $t('pages.noPages') }}</p>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    pages: Array
});
</script>
