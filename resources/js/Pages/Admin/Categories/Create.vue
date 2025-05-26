<template>
  <AdminLayout title="Создание категории">
    <div class="max-w-3xl mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Создание категории</h1>
        <Link :href="route('admin.categories.index')" class="text-indigo-600 hover:text-indigo-900">
          Назад к списку
        </Link>
      </div>

      <div class="bg-white shadow-md rounded-lg p-6">
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <InputLabel for="name_ru" value="Название (RU)" />
              <TextInput
                id="name_ru"
                v-model="form.name_ru"
                type="text"
                class="mt-1 block w-full"
                required
              />
              <InputError :message="form.errors.name_ru" class="mt-2" />
            </div>

            <div>
              <InputLabel for="name_en" value="Название (EN)" />
              <TextInput
                id="name_en"
                v-model="form.name_en"
                type="text"
                class="mt-1 block w-full"
                required
              />
              <InputError :message="form.errors.name_en" class="mt-2" />
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
                {{ category.name_ru }}
              </option>
            </SelectInput>
            <InputError :message="form.errors.parent_id" class="mt-2" />
          </div>

          <div class="mb-6">
            <InputLabel for="slug" value="Slug (опционально)" />
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
            <FileInput
              id="image"
              @input="form.image = $event.target.files[0]"
              class="mt-1 block w-full"
            />
            <div class="mt-1 text-sm text-gray-500">
              Рекомендуемый размер: 800x800px, JPG или PNG
            </div>
            <InputError :message="form.errors.image" class="mt-2" />
            
            <div v-if="form.image" class="mt-2">
              <img :src="previewImage" class="h-32 w-32 object-cover rounded-md" alt="Image Preview" />
            </div>
          </div>

          <div class="mb-6">
            <div class="flex items-center">
              <Checkbox id="active" v-model:checked="form.active" />
              <InputLabel for="active" value="Активна" class="ml-2" />
            </div>
            <InputError :message="form.errors.active" class="mt-2" />
          </div>

          <div class="mb-6">
            <InputLabel for="description_ru" value="Описание (RU)" />
            <Textarea
              id="description_ru"
              v-model="form.description_ru"
              class="mt-1 block w-full"
              rows="4"
            />
            <InputError :message="form.errors.description_ru" class="mt-2" />
          </div>

          <div class="mb-6">
            <InputLabel for="description_en" value="Описание (EN)" />
            <Textarea
              id="description_en"
              v-model="form.description_en"
              class="mt-1 block w-full"
              rows="4"
            />
            <InputError :message="form.errors.description_en" class="mt-2" />
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
              Создать
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
  categories: Array
});

const form = useForm({
  name_ru: '',
  name_en: '',
  slug: '',
  parent_id: null,
  image: null,
  active: true,
  description_ru: '',
  description_en: '',
});

const previewImage = computed(() => {
  if (!form.image) return null;
  return URL.createObjectURL(form.image);
});

const submit = () => {
  form.post(route('admin.categories.store'), {
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