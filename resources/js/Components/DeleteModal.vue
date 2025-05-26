<template>
    <Modal :show="open" @close="$emit('cancel')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-2">
                {{ title }}
            </h2>

            <p class="text-sm text-gray-600 mb-6">
                {{ message }}
            </p>

            <div class="flex justify-end">
                <Button
                    @click="$emit('cancel')"
                    class="mr-2 bg-gray-200 text-gray-800 hover:bg-gray-300"
                >
                    Отмена
                </Button>
                <Button
                    @click="$emit('confirm')"
                    class="bg-red-600 hover:bg-red-700"
                >
                    Удалить
                </Button>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import Button from '@/Components/Button.vue';

defineProps({
    open: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        default: 'Подтвердите удаление',
    },
    message: {
        type: String,
        default: 'Вы уверены, что хотите удалить этот элемент? Это действие нельзя отменить.',
    },
});

defineEmits(['confirm', 'cancel']);
</script>
