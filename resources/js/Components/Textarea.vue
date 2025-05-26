<template>
  <textarea
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
      :rows="rows"
  ></textarea>
</template>

<script setup>
defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    rows: {
        type: Number,
        default: 4,
    },
});

defineEmits(['update:modelValue']);
</script>
