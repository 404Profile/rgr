<template>
    <AdminLayout title="Редактирование товара">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Редактирование товара</h1>
                <Link :href="route('admin.products.index')" class="text-indigo-600 hover:text-indigo-900">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <InputLabel for="category_id" value="Категория" />
                            <SelectInput
                                id="category_id"
                                v-model="form.category_id"
                                class="mt-1 block w-full"
                                required
                            >
                                <option :value="null" disabled>Выберите категорию</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name_ru }}
                                </option>
                            </SelectInput>
                            <InputError :message="form.errors.category_id" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="brand_id" value="Бренд" />
                            <SelectInput
                                id="brand_id"
                                v-model="form.brand_id"
                                class="mt-1 block w-full"
                                required
                            >
                                <option :value="null" disabled>Выберите бренд</option>
                                <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                    {{ brand.name_ru }}
                                </option>
                            </SelectInput>
                            <InputError :message="form.errors.brand_id" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <InputLabel for="price" value="Цена" />
                            <TextInput
                                id="price"
                                v-model="form.price"
                                type="number"
                                step="0.01"
                                min="0"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.price" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="quantity" value="Количество" />
                            <TextInput
                                id="quantity"
                                v-model="form.quantity"
                                type="number"
                                min="0"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.quantity" class="mt-2" />
                        </div>

                        <div>
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
                    </div>

                    <div class="mb-6">
                        <InputLabel for="image" value="Основное изображение" />
                        <div v-if="product.image" class="mt-2 mb-2">
                            <p class="text-sm text-gray-600 mb-2">Текущее изображение:</p>
                            <img :src="getImageUrl(product.image)" class="h-32 w-32 object-cover rounded-md" alt="Product Image" />
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

                        <div v-if="form.image" class="mt-2">
                            <p class="text-sm text-gray-600 mb-2">Новое изображение:</p>
                            <img :src="previewImage" class="h-32 w-32 object-cover rounded-md" alt="Image Preview" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <InputLabel for="gallery" value="Галерея изображений" />
                        <div v-if="product.gallery && product.gallery.length" class="mt-2 mb-2">
                            <p class="text-sm text-gray-600 mb-2">Текущая галерея:</p>
                            <div class="flex flex-wrap gap-2">
                                <div v-for="(image, index) in product.gallery" :key="index" class="relative">
                                    <img :src="getImageUrl(image)" class="h-24 w-24 object-cover rounded-md" :alt="`Gallery Image ${index+1}`" />
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
                                При загрузке новых изображений, текущие будут заменены
                            </p>
                        </div>
                        <FileInput
                            id="gallery"
                            @input="form.gallery = $event.target.files"
                            class="mt-1 block w-full"
                            multiple
                        />
                        <InputError :message="form.errors.gallery" class="mt-2" />

                        <div v-if="previewGallery.length" class="mt-2">
                            <p class="text-sm text-gray-600 mb-2">Новая галерея:</p>
                            <div class="flex flex-wrap gap-2">
                                <div v-for="(preview, index) in previewGallery" :key="index" class="relative">
                                    <img :src="preview" class="h-24 w-24 object-cover rounded-md" :alt="`Gallery Preview ${index+1}`" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex items-center">
                            <Checkbox id="active" v-model:checked="form.active" />
                            <InputLabel for="active" value="Активен" class="ml-2" />
                        </div>
                        <InputError :message="form.errors.active" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="description_ru" value="Описание (RU)" />
                        <RichEditor
                            id="description_ru"
                            v-model="form.description_ru"
                            class="mt-1"
                        />
                        <InputError :message="form.errors.description_ru" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel for="description_en" value="Описание (EN)" />
                        <RichEditor
                            id="description_en"
                            v-model="form.description_en"
                            class="mt-1"
                        />
                        <InputError :message="form.errors.description_en" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <InputLabel value="Характеристики" />
                        <div class="mt-2 space-y-3">
                            <div v-for="(spec, index) in specifications" :key="index" class="grid grid-cols-7 gap-2">
                                <div class="col-span-3">
                                    <TextInput
                                        v-model="spec.name"
                                        type="text"
                                        class="block w-full"
                                        placeholder="Название"
                                    />
                                </div>
                                <div class="col-span-3">
                                    <TextInput
                                        v-model="spec.value"
                                        type="text"
                                        class="block w-full"
                                        placeholder="Значение"
                                    />
                                </div>
                                <div class="col-span-1">
                                    <Button
                                        type="button"
                                        @click="removeSpecification(index)"
                                        class="bg-red-600 hover:bg-red-700 w-full h-full flex items-center justify-center"
                                    >
                                        <XMarkIcon class="h-5 w-5" />
                                    </Button>
                                </div>
                            </div>
                            <Button
                                type="button"
                                @click="addSpecification"
                                class="mt-2 bg-gray-600 hover:bg-gray-700"
                            >
                                Добавить характеристику
                            </Button>
                        </div>
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
import { ref, computed, onMounted, watch } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import FileInput from '@/Components/FileInput.vue';
import RichEditor from '@/Components/RichEditor.vue';

const props = defineProps({
    product: Object,
    categories: Array,
    brands: Array
});

const specifications = ref([]);

onMounted(() => {
    if (props.product.specifications && Object.keys(props.product.specifications).length > 0) {
        specifications.value = Object.entries(props.product.specifications).map(([name, value]) => ({
            name,
            value
        }));
    } else {
        specifications.value = [{ name: '', value: '' }];
    }
});

const form = useForm({
    name_ru: props.product.name_ru,
    name_en: props.product.name_en,
    slug: props.product.slug,
    category_id: props.product.category_id,
    brand_id: props.product.brand_id,
    price: props.product.price,
    quantity: props.product.quantity,
    image: null,
    gallery: null,
    active: props.product.active,
    description_ru: props.product.description_ru || '',
    description_en: props.product.description_en || '',
    specifications: {},
    _method: 'PUT'
});

const getImageUrl = (path) => {
    return `/storage/${path}`;
};

const previewImage = computed(() => {
    if (!form.image) return null;
    return URL.createObjectURL(form.image);
});

const previewGallery = computed(() => {
    if (!form.gallery) return [];
    return Array.from(form.gallery).map(file => URL.createObjectURL(file));
});

const addSpecification = () => {
    specifications.value.push({ name: '', value: '' });
};

const removeSpecification = (index) => {
    specifications.value.splice(index, 1);
    if (specifications.value.length === 0) {
        addSpecification();
    }
};

watch(specifications, (value) => {
    const specs = {};
    value.filter(spec => spec.name && spec.value).forEach(spec => {
        specs[spec.name] = spec.value;
    });
    form.specifications = specs;
}, { deep: true });

const submit = () => {
    const specs = {};
    specifications.value.filter(spec => spec.name && spec.value).forEach(spec => {
        specs[spec.name] = spec.value;
    });
    form.specifications = specs;

    form.post(route('admin.products.update', props.product.id), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('admin.products.index'));
        }
    });
};

const cancel = () => {
    router.visit(route('admin.products.index'));
};
</script>
