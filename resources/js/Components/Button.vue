<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        :class="[className]"
        :disabled="disabled"
    >
        <slot />
    </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    className: {
        type: String,
        default: 'bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>
