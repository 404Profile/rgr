<template>
    <Head :title="$t('about.title')" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ $t('about.subtitle') }}</h1>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    {{ $t('about.intro') }}
                </p>
            </div>

            <!-- История компании -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $t('about.history.title') }}</h2>
                        <p class="text-gray-600 mb-4">
                            {{ $t('about.history.text1') }}
                        </p>
                        <p class="text-gray-600">
                            {{ $t('about.history.text2') }}
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
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ $t('about.mission.title') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="rounded-full bg-indigo-100 p-3 inline-flex items-center justify-center mb-4">
                            <SparklesIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $t('about.mission.quality.title') }}</h3>
                        <p class="text-gray-600">
                            {{ $t('about.mission.quality.description') }}
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="rounded-full bg-indigo-100 p-3 inline-flex items-center justify-center mb-4">
                            <UserGroupIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $t('about.mission.customer.title') }}</h3>
                        <p class="text-gray-600">
                            {{ $t('about.mission.customer.description') }}
                        </p>
                    </div>
                    <div class="text-center">
                        <div class="rounded-full bg-indigo-100 p-3 inline-flex items-center justify-center mb-4">
                            <LightBulbIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $t('about.mission.innovation.title') }}</h3>
                        <p class="text-gray-600">
                            {{ $t('about.mission.innovation.description') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Наша команда -->
            <div class="bg-white shadow-md rounded-lg p-8 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ $t('about.team.title') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1557862921-37829c790f19?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=776&q=80"
                                :alt="$t('about.team.member1.name')"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $t('about.team.member1.name') }}</h3>
                        <p class="text-gray-600">{{ $t('about.team.member1.position') }}</p>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                                :alt="$t('about.team.member2.name')"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $t('about.team.member2.name') }}</h3>
                        <p class="text-gray-600">{{ $t('about.team.member2.position') }}</p>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
                                :alt="$t('about.team.member3.name')"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $t('about.team.member3.name') }}</h3>
                        <p class="text-gray-600">{{ $t('about.team.member3.position') }}</p>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <img
                                src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80"
                                :alt="$t('about.team.member4.name')"
                                class="w-32 h-32 object-cover rounded-full mx-auto"
                            >
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $t('about.team.member4.name') }}</h3>
                        <p class="text-gray-600">{{ $t('about.team.member4.position') }}</p>
                    </div>
                </div>
            </div>

            <!-- Почему выбирают нас -->
            <div class="bg-white shadow-md rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ $t('about.whyUs.title') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">{{ $t('about.whyUs.reason1.title') }}</h3>
                            <p class="mt-1 text-gray-600">
                                {{ $t('about.whyUs.reason1.description') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">{{ $t('about.whyUs.reason2.title') }}</h3>
                            <p class="mt-1 text-gray-600">
                                {{ $t('about.whyUs.reason2.description') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">{{ $t('about.whyUs.reason3.title') }}</h3>
                            <p class="mt-1 text-gray-600">
                                {{ $t('about.whyUs.reason3.description') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">{{ $t('about.whyUs.reason4.title') }}</h3>
                            <p class="mt-1 text-gray-600">
                                {{ $t('about.whyUs.reason4.description') }}
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
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
</script>
