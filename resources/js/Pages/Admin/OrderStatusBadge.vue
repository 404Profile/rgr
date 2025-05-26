<template>
  <span :class="badgeClasses">
    {{ statusLabel }}
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
});

const statusColors = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    shipped: 'bg-purple-100 text-purple-800',
    delivered: 'bg-indigo-100 text-indigo-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
    refunded: 'bg-orange-100 text-orange-800',
};

const statusLabels = {
    pending: 'Ожидает обработки',
    processing: 'В обработке',
    shipped: 'Отправлен',
    delivered: 'Доставлен',
    completed: 'Завершен',
    cancelled: 'Отменен',
    refunded: 'Возвращен',
};

const badgeClasses = computed(() => {
    return `px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
        statusColors[props.status] || 'bg-gray-100 text-gray-800'
    }`;
});

const statusLabel = computed(() => {
    return statusLabels[props.status] || props.status;
});
</script>
