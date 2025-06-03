
<template>
    <div class="relative">
        <select
            v-model="currentLocale"
            @change="changeLocale"
            class="appearance-none bg-transparent border border-gray-300 rounded-md px-3 py-1 pr-8 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
        >
            <option value="ru">{{ $t('language.ru') }}</option>
            <option value="en">{{ $t('language.en') }}</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import {setLocale} from "@/Components/Lang/i18Plugin.js";

const { locale } = useI18n();
const currentLocale = ref(locale.value);

const changeLocale = () => {
    setLocale(currentLocale.value);
};

onMounted(() => {
    currentLocale.value = localStorage.getItem('locale') || 'ru';
});
</script>
