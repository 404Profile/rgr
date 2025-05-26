<template>
    <input
        type="file"
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
        @input="$emit('input', $event)"
        :accept="accept"
        :multiple="multiple"
    />
</template>

<script setup>
defineProps({
    accept: {
        type: String,
        default: 'image/*',
    },
    multiple: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['input']);
</script>
