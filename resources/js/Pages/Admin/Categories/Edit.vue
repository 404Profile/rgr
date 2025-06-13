<template>
  <AdminLayout title="Редактирование категории">
    <div class="max-w-3xl mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Редактирование категории</h1>
        <Link :href="route('admin.categories.index')" class="text-indigo-600 hover:text-indigo-900">
          Назад к списку
        </Link>
      </div>

      <div class="bg-white shadow-md rounded-lg p-6">
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <InputLabel for="name" value="Название" />
              <TextInput
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full"
                required
              />
              <InputError :message="form.errors.name" class="mt-2" />
            </div>
          </div>

          <div class="mb-6">
            <InputLabel for="parent_id" value="Родительская категория" />
            <SelectInput
              id="parent_id"
              v-model="form.parent_id"
              class="mt-1 block w-full"
            >
              <option :value="null">Нет (корневая категория)</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </SelectInput>
            <InputError :message="form.errors.parent_id" class="mt-2" />
          </div>

          <div class="mb-6">
            <InputLabel for="slug" value="Slug" />
            <TextInput
              id="slug"
              v-model="form.slug"
              type="text"
              class="mt-1 block w-full"
            />
            <div class="mt-1 text-sm text-gray-500">
              Если оставить пустым, будет сгенерирован автоматически
            </div>
            <InputError :message="form.errors.slug" class="mt-2" />
          </div>

            <div class="mb-6">
                <InputLabel for="image" value="Изображение" />
                <div v-if="category.image" class="mt-2 mb-2">
                    <p class="text-sm text-gray-600 mb-2">Текущее изображение:</p>
                    <img :src="getImageUrl(category.image)" class="h-32 w-32 object-cover rounded-md" alt="Category Image" />
                    <label class="flex items-center mt-2">
                        <input type="checkbox" v-model="form.remove_image">
                        <span class="ml-2">Удалить изображение</span>
                    </label>
                </div>
                <FileInput
                    id="image"
                    @input="form.image = $event.target.files[0]"
                    class="mt-1 block w-full"
                />
                <div class="mt-1 text-sm text-gray-500">
                    Рекомендуемый размер: 800x800px, JPG или PNG
                </div>
                <InputError :message="form.errors.image" class="mt-2" />
            </div>


            <div class="mb-6">
            <div class="flex items-center">
              <Checkbox id="active" v-model:checked="form.active" />
              <InputLabel for="active" value="Активна" class="ml-2" />
            </div>
            <InputError :message="form.errors.active" class="mt-2" />
          </div>

          <div class="mb-6">
            <InputLabel for="description" value="Описание" />
            <Textarea
              id="description"
              v-model="form.description"
              class="mt-1 block w-full"
              rows="4"
            />
            <InputError :message="form.errors.description" class="mt-2" />
          </div>

          <div class="flex items-center justify-end">
            <Button
              type="button"
              class="mr-2"
              :class="{ 'opacity-25': form.processing }"
              @click="cancel"
              :disabled="form.processing"
            >
              Отмена
            </Button>
            <Button
              type="submit"
              class="bg-indigo-600 hover:bg-indigo-700"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Сохранить
            </Button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Textarea from '@/Components/Textarea.vue';
import FileInput from '@/Components/FileInput.vue';

const props = defineProps({
  category: Object,
  categories: Array
});

const form = useForm({
  name: props.category.name,
  slug: props.category.slug,
  parent_id: props.category.parent_id,
  image: null,
  active: props.category.active,
  description: props.category.description || '',
  remove_image: false,
  _method: 'PUT'
});

const getImageUrl = (path) => {
  return `/storage/${path}`;
};

const previewImage = computed(() => {
  if (!form.image) return null;
  return URL.createObjectURL(form.image);
});

const submit = () => {
  form.post(route('admin.categories.update', props.category.id), {
    preserveScroll: true,
    onSuccess: () => {
      router.visit(route('admin.categories.index'));
    }
  });
};

const cancel = () => {
  router.visit(route('admin.categories.index'));
};
</script>
