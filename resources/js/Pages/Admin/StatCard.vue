<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center">
                <div :class="`rounded-full p-3 ${color} text-white`">
                    <component :is="iconComponent" class="h-6 w-6" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">{{ title }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ value }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import {
    CurrencyRubleIcon,
    ShoppingBagIcon,
    ClockIcon,
    ArchiveBoxIcon,
    UsersIcon,
    ChartBarIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    icon: {
        type: String,
        default: 'chart-bar',
    },
    color: {
        type: String,
        default: 'bg-blue-500',
    },
});

const iconMapping = {
    'currency-ruble': CurrencyRubleIcon,
    'shopping-bag': ShoppingBagIcon,
    'clock': ClockIcon,
    'archive-box': ArchiveBoxIcon,
    'users': UsersIcon,
    'chart-bar': ChartBarIcon,
};

const iconComponent = computed(() => {
    return iconMapping[props.icon] || ChartBarIcon;
});
</script>
