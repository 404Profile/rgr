<template>
    <Head :title="title" />

    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Логотип -->
                        <div class="shrink-0 flex items-center">
                            <Link href="/admin" class="flex items-center">
                                <span class="text-xl font-bold text-indigo-600">Admin Panel</span>
                            </Link>
                        </div>

                        <!-- Навигация -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <NavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                                Панель управления
                            </NavLink>
                            <NavLink :href="route('admin.products.index')" :active="route().current('admin.products.*')">
                                Товары
                            </NavLink>
                            <NavLink :href="route('admin.categories.index')" :active="route().current('admin.categories.*')">
                                Категории
                            </NavLink>
                            <NavLink :href="route('admin.brands.index')" :active="route().current('admin.brands.*')">
                                Бренды
                            </NavLink>
                            <NavLink :href="route('admin.orders.index')" :active="route().current('admin.orders.*')">
                                Заказы
                            </NavLink>
                            <NavLink :href="route('admin.users.index')" :active="route().current('admin.users.*')">
                                Пользователи
                            </NavLink>
                            <NavLink :href="route('admin.news.index')" :active="route().current('admin.news.*')">
                                Новости
                            </NavLink>
                            <NavLink :href="route('admin.pages.index')" :active="route().current('admin.pages.*')">
                                Страницы
                            </NavLink>
                            <NavLink :href="route('admin.contacts.index')" :active="route().current('admin.contacts.*')">
                                Контакты
                            </NavLink>
                        </div>
                    </div>

                    <!-- Правая часть навигации -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="relative" ref="userDropdownContainer">
                            <button
                                @click="userDropdownOpen = !userDropdownOpen"
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out"
                            >
                                <div>{{ $page.props.auth.user.name }}</div>
                                <div class="ml-1">
                                    <ChevronDownIcon
                                        class="w-4 h-4 fill-current"
                                        :class="{'rotate-180': userDropdownOpen}"
                                    />
                                </div>
                            </button>

                            <!-- Выпадающее меню -->
                            <div
                                v-show="userDropdownOpen"
                                class="absolute right-0 mt-2 w-48 py-1 bg-white rounded-md shadow-lg z-10"
                            >
                                <Link
                                    :href="route('profile.edit')"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >
                                    Профиль
                                </Link>
                                <Link
                                    :href="route('dashboard')"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >
                                    Сайт
                                </Link>
                                <button
                                    @click="logout"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >
                                    Выйти
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Мобильное меню -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        >
                            <Bars3Icon v-if="!mobileMenuOpen" class="h-6 w-6" />
                            <XMarkIcon v-else class="h-6 w-6" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Мобильная навигация -->
            <div class="sm:hidden" v-show="mobileMenuOpen">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                        Панель управления
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.products.index')" :active="route().current('admin.products.*')">
                        Товары
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.categories.index')" :active="route().current('admin.categories.*')">
                        Категории
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.brands.index')" :active="route().current('admin.brands.*')">
                        Бренды
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.orders.index')" :active="route().current('admin.orders.*')">
                        Заказы
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.users.index')" :active="route().current('admin.users.*')">
                        Пользователи
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.news.index')" :active="route().current('admin.news.*')">
                        Новости
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.pages.index')" :active="route().current('admin.pages.*')">
                        Страницы
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.contacts.index')" :active="route().current('admin.contacts.*')">
                        Контакты
                    </ResponsiveNavLink>
                </div>

                <!-- Мобильная информация о пользователе -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">
                            Профиль
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('dashboard')">
                            Сайт
                        </ResponsiveNavLink>
                        <button
                            @click="logout"
                            class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
                        >
                            Выйти
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Заголовок страницы -->
        <header class="bg-white shadow" v-if="title">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">{{ title }}</h1>
            </div>
        </header>

        <!-- Основной контент -->
        <main class="py-6">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Уведомления -->
                <div v-if="$page.props.flash.success" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash.error" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    {{ $page.props.flash.error }}
                </div>

                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {
    Bars3Icon,
    XMarkIcon,
    ChevronDownIcon
} from '@heroicons/vue/24/outline';

import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: {
        type: String,
        default: '',
    },
});

const mobileMenuOpen = ref(false);
const userDropdownOpen = ref(false);
const userDropdownContainer = ref(null);

const logout = () => {
    router.post(route('logout'));
};

const closeUserDropdown = (e) => {
    if (userDropdownContainer.value && !userDropdownContainer.value.contains(e.target)) {
        userDropdownOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', closeUserDropdown);
});

onUnmounted(() => {
    document.removeEventListener('click', closeUserDropdown);
});
</script>
