<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Верхняя навигация -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Логотип -->
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">
                                {{ $t('common.shopName')}}
                            </Link>
                        </div>

                        <!-- Навигационные ссылки -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <NavLink :href="route('catalog.index')" :active="route().current('catalog.index')">
                                {{ $t('navigation.catalog') }}
                            </NavLink>
                            <NavLink :href="route('about')" :active="route().current('about')">
                                {{ $t('navigation.about') }}
                            </NavLink>
                            <NavLink :href="route('contact.index')" :active="route().current('contact.index')">
                                {{ $t('navigation.contacts') }}
                            </NavLink>
                            <NavLink :href="route('news.index')" :active="route().current('news.*')">
                                {{ $t('navigation.news') }}
                            </NavLink>
                        </div>
                    </div>

                    <!-- Правая часть навигации -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        <!-- Селектор языка -->
                        <LanguageSelector />

                        <!-- Корзина -->
                        <Link :href="route('cart.index')" class="relative px-3 py-2">
                            <ShoppingCartIcon class="h-6 w-6 text-gray-600 hover:text-indigo-600" />
                            <span v-if="cartItemsCount > 0" class="absolute inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-indigo-600 rounded-full -top-1 -right-1">
                {{ cartItemsCount }}
              </span>
                        </Link>

                        <!-- Аутентификация -->
                        <template v-if="$page.props.auth.user">
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
                                        :href="route('profile.orders')"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Мои заказы
                                    </Link>
                                    <template v-if="$page.props.auth.user.role === 'admin'">
                                        <Link
                                            :href="route('admin.dashboard')"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            Панель администратора
                                        </Link>
                                    </template>
                                    <button
                                        @click="logout"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Выйти
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-gray-600 hover:text-indigo-600"
                            >
                                Войти
                            </Link>
                            <Link
                                :href="route('register')"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
                            >
                                Регистрация
                            </Link>
                        </template>
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
                    <ResponsiveNavLink :href="route('catalog.index')" :active="route().current('catalog.index')">
                        Каталог
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('about')" :active="route().current('about')">
                        О нас
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('contact.index')" :active="route().current('contact.index')">
                        Контакты
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('news.index')" :active="route().current('news.*')">
                        Новости и акции
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('cart.index')" :active="route().current('cart.index')">
                        Корзина
                        <span v-if="cartItemsCount > 0" class="ml-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-indigo-600 rounded-full">
              {{ cartItemsCount }}
            </span>
                    </ResponsiveNavLink>
                </div>

                <!-- Мобильная аутентификация -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div v-if="$page.props.auth.user" class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <template v-if="$page.props.auth.user">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Профиль
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('profile.orders')">
                                Мои заказы
                            </ResponsiveNavLink>
                            <template v-if="$page.props.auth.user.role === 'admin'">
                                <ResponsiveNavLink :href="route('admin.dashboard')">
                                    Панель администратора
                                </ResponsiveNavLink>
                            </template>
                            <button
                                @click="logout"
                                class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
                            >
                                Выйти
                            </button>
                        </template>
                        <template v-else>
                            <ResponsiveNavLink :href="route('login')">
                                Войти
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('register')">
                                Регистрация
                            </ResponsiveNavLink>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Уведомления -->
        <div v-if="$page.props.flash.success" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ $page.props.flash.success }}
            </div>
        </div>
        <div v-if="$page.props.flash.error" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                {{ $page.props.flash.error }}
            </div>
        </div>

        <!-- Основной контент -->
        <main>
            <slot />
        </main>

        <!-- Футер -->
        <footer class="bg-white mt-12 border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ $t('footer.about') }}</h3>
                        <p class="text-gray-600">
                            {{ $t('footer.aboutText') }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ $t('footer.links') }}</h3>
                        <ul class="space-y-2">
                            <li>
                                <Link :href="route('catalog.index')" class="text-gray-600 hover:text-indigo-600">{{ $t('navigation.catalog') }}</Link>
                            </li>
                            <li>
                                <Link :href="route('about')" class="text-gray-600 hover:text-indigo-600">{{ $t('footer.about') }}</Link>
                            </li>
                            <li>
                                <Link :href="route('contact.index')" class="text-gray-600 hover:text-indigo-600">{{ $t('footer.contacts') }}</Link>
                            </li>
                            <li>
                                <Link :href="route('news.index')" class="text-gray-600 hover:text-indigo-600">{{ $t('admin.news') }}</Link>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ $t('navigation.contacts') }}</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-600">
                                <MapPinIcon class="h-5 w-5 mr-2" />
                                <span>123 ул. Примерная, г. Москва</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <PhoneIcon class="h-5 w-5 mr-2" />
                                <span>+7 (123) 456-78-90</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <EnvelopeIcon class="h-5 w-5 mr-2" />
                                <span>info@example.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-200 text-center text-gray-600">
                    <p>&copy; {{ new Date().getFullYear() }} {{ $t('common.shopName')}}. {{ $t('footer.rights') }}.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import {Link, router, usePage} from '@inertiajs/vue3';
import {
    Bars3Icon,
    XMarkIcon,
    ChevronDownIcon,
    ShoppingCartIcon,
    MagnifyingGlassIcon,
    MapPinIcon,
    PhoneIcon,
    EnvelopeIcon
} from '@heroicons/vue/24/outline';

import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import LanguageSelector from "@/Components/Lang/LanguageSelector.vue";

const mobileMenuOpen = ref(false);
const userDropdownOpen = ref(false);
const userDropdownContainer = ref(null);

// Количество товаров в корзине
const cartItemsCount = computed(() => {
    return usePage().props.cart?.items_count || 0;
});

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
