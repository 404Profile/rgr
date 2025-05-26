<template>
    <QuillEditor
        :id="id"
        :content="modelValue"
        @update:content="emit('update:modelValue', $event)"
        :options="editorOptions"
        :style="{ height: height + 'px' }"
        theme="snow"
        toolbar="full"
        contentType="html"
    />
</template>

<script setup>
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String,
        required: true,
    },
    height: {
        type: Number,
        default: 400,
    },
});

const emit = defineEmits(['update:modelValue']);

const editorOptions = {
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'script': 'sub' }, { 'script': 'super' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],
            [{ 'align': [] }],
            ['clean'],
            ['link', 'image', 'video']
        ],
    },
    placeholder: 'Введите текст...',
};

// Добавление обработчика загрузки изображений
// Это требует дополнительной настройки, если вам нужна загрузка изображений
const setupImageUpload = () => {
    const quill = document.querySelector(`#${props.id} .ql-editor`);
    if (quill) {
        // Здесь можно добавить обработчик загрузки изображений
        // Это более сложная задача в Quill и может потребовать
        // дополнительных плагинов или кастомной реализации
    }
};

// Если нужна кастомная обработка загрузки изображений, можно
// активировать этот код после полной настройки
// onMounted(setupImageUpload);
</script>
