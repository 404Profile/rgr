<template>
    <Head :title="product.name_ru" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <!-- Хлебные крошки -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <Link :href="route('home')" class="text-gray-500 hover:text-gray-700">Главная</Link>
                    </li>
                    <li>
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li>
                        <Link :href="route('catalog.index')" class="text-gray-500 hover:text-gray-700">Каталог</Link>
                    </li>
                    <li v-if="product.category">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li v-if="product.category">
                        <Link
                            :href="route('catalog.category', { slug: product.category.slug })"
                            class="text-gray-500 hover:text-gray-700"
                        >
                            {{ product.category.name_ru }}
                        </Link>
                    </li>
                    <li>
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-900 font-medium">{{ product.name_ru }}</span>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Изображение товара -->
                <div>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img
                            :src="product.image ? `/storage/${product.image}` : '/images/placeholder.jpg'"
                            :alt="product.name_ru"
                            class="w-full h-auto object-cover"
                        >
                    </div>
                    <div v-if="product.gallery && product.gallery.length" class="grid grid-cols-4 gap-2 mt-2">
                        <div
                            v-for="(image, index) in product.gallery"
                            :key="index"
                            class="bg-white rounded-lg shadow-sm overflow-hidden cursor-pointer"
                        >
                            <img
                                :src="`/storage/${image}`"
                                :alt="`${product.name_ru} - изображение ${index + 1}`"
                                class="w-full h-24 object-cover"
                            >
                        </div>
                    </div>
                </div>

                <!-- Информация о товаре -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h1 class="text-2xl font-bold text-gray-900">{{ product.name_ru }}</h1>

                        <div class="mt-4 flex items-center">
                            <div class="flex items-center">
                <span v-for="i in 5" :key="i" class="mr-1">
                  <StarIcon
                      :class="[
                      'h-5 w-5',
                      i <= product.rating ? 'text-yellow-400' : 'text-gray-300'
                    ]"
                  />
                </span>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">{{ product.rating || 0 }} / 5 ({{ product.reviews_count || 0 }} отзывов)</span>
                        </div>

                        <div class="mt-4">
                            <span class="text-3xl font-bold text-gray-900">{{ formatCurrency(product.price) }}</span>
                            <span v-if="product.old_price" class="ml-2 text-lg text-gray-500 line-through">
                {{ formatCurrency(product.old_price) }}
              </span>
                        </div>

                        <div v-if="product.stock > 0" class="mt-4 flex items-center">
                            <CheckCircleIcon class="h-5 w-5 text-green-500" />
                            <span class="ml-2 text-sm text-green-700">В наличии</span>
                        </div>
                        <div v-else class="mt-4 flex items-center">
                            <XCircleIcon class="h-5 w-5 text-red-500" />
                            <span class="ml-2 text-sm text-red-700">Нет в наличии</span>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center mb-4">
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mr-4">Количество:</label>
                                <div class="flex items-center border border-gray-300 rounded-md">
                                    <button
                                        @click="decreaseQuantity"
                                        class="p-2 text-gray-600 hover:text-gray-900"
                                        :disabled="quantity <= 1"
                                        :class="{ 'opacity-50 cursor-not-allowed': quantity <= 1 }"
                                    >
                                        <MinusIcon class="h-4 w-4" />
                                    </button>
                                    <input
                                        id="quantity"
                                        type="number"
                                        v-model="quantity"
                                        min="1"
                                        :max="product.stock"
                                        class="w-12 text-center border-none focus:ring-0"
                                    />
                                    <button
                                        @click="increaseQuantity"
                                        class="p-2 text-gray-600 hover:text-gray-900"
                                        :disabled="quantity >= product.stock"
                                        :class="{ 'opacity-50 cursor-not-allowed': quantity >= product.stock }"
                                    >
                                        <PlusIcon class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <button
                                    @click="addToCart"
                                    class="w-full py-3 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                    :disabled="product.stock <= 0"
                                    :class="{ 'opacity-50 cursor-not-allowed': product.stock <= 0 }"
                                >
                  <span class="flex items-center justify-center">
                    <ShoppingCartIcon class="h-5 w-5 mr-2" />
                    В корзину
                  </span>
                                </button>
                                <button
                                    @click="addToFavorites"
                                    class="w-full py-3 px-4 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                  <span class="flex items-center justify-center">
                    <HeartIcon
                        :class="[
                        'h-5 w-5 mr-2',
                        isInFavorites ? 'text-red-500' : 'text-gray-400'
                      ]"
                    />
                    {{ isInFavorites ? 'В избранном' : 'В избранное' }}
                  </span>
                                </button>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <div class="text-sm text-gray-600 space-y-2">
                                <div v-if="product.sku" class="flex">
                                    <span class="font-medium w-32">Артикул:</span>
                                    <span>{{ product.sku }}</span>
                                </div>
                                <div v-if="product.brand" class="flex">
                                    <span class="font-medium w-32">Бренд:</span>
                                    <span>{{ product.brand.name }}</span>
                                </div>
                                <div v-if="product.category" class="flex">
                                    <span class="font-medium w-32">Категория:</span>
                                    <Link :href="route('catalog.category', { slug: product.category.slug })" class="text-indigo-600 hover:text-indigo-700">
                                        {{ product.category.name_ru }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Описание товара -->
            <div class="mt-8">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Описание</h2>
                    <div class="prose max-w-none" v-html="product.description_ru"></div>
                </div>
            </div>

            <!-- Характеристики товара -->
            <div v-if="product.specifications && Object.keys(product.specifications).length" class="mt-8">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Характеристики</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                        <template v-for="(value, key) in product.specifications" :key="key">
                            <dt class="text-sm font-medium text-gray-700">{{ key }}</dt>
                            <dd class="text-sm text-gray-900">{{ value }}</dd>
                        </template>
                    </dl>
                </div>
            </div>

            <!-- Отзывы -->
            <div class="mt-8">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">Отзывы ({{ product.reviews_count || 0 }})</h2>
                        <button
                            @click="showReviewForm = !showReviewForm"
                            class="text-indigo-600 hover:text-indigo-700 text-sm font-medium"
                        >
                            Оставить отзыв
                        </button>
                    </div>

                    <!-- Форма отзыва -->
                    <div v-if="showReviewForm" class="mb-8 bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ваш отзыв</h3>
                        <form @submit.prevent="submitReview">
                            <div class="mb-4">
                                <InputLabel for="rating" value="Оценка" />
                                <div class="flex mt-1">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="reviewForm.rating = star"
                                        class="p-1 focus:outline-none"
                                    >
                                        <StarIcon
                                            :class="[
                        'h-6 w-6',
                        star <= reviewForm.rating ? 'text-yellow-400' : 'text-gray-300'
                      ]"
                                        />
                                    </button>
                                </div>
                                <InputError :message="reviewForm.errors.rating" class="mt-1" />
                            </div>
                            <div class="mb-4">
                                <InputLabel for="name" value="Имя" />
                                <TextInput
                                    id="name"
                                    v-model="reviewForm.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="reviewForm.errors.name" class="mt-1" />
                            </div>
                            <div class="mb-4">
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    v-model="reviewForm.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="reviewForm.errors.email" class="mt-1" />
                            </div>
                            <div class="mb-4">
                                <InputLabel for="comment" value="Отзыв" />
                                <Textarea
                                    id="comment"
                                    v-model="reviewForm.comment"
                                    class="mt-1 block w-full"
                                    rows="4"
                                    required
                                />
                                <InputError :message="reviewForm.errors.comment" class="mt-1" />
                            </div>
                            <div class="flex justify-end">
                                <Button
                                    type="button"
                                    @click="showReviewForm = false"
                                    class="mr-2"
                                >
                                    Отмена
                                </Button>
                                <Button
                                    type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white"
                                    :disabled="reviewForm.processing"
                                >
                                    Отправить
                                </Button>
                            </div>
                        </form>
                    </div>

                    <!-- Список отзывов -->
                    <div v-if="product.reviews && product.reviews.length" class="divide-y divide-gray-200">
                        <div v-for="review in product.reviews" :key="review.id" class="py-4">
                            <div class="flex items-center mb-1">
                                <div class="flex items-center">
                  <span v-for="i in 5" :key="i" class="mr-1">
                    <StarIcon
                        :class="[
                        'h-4 w-4',
                        i <= review.rating ? 'text-yellow-400' : 'text-gray-300'
                      ]"
                    />
                  </span>
                                </div>
                                <span class="ml-2 text-sm text-gray-600">{{ formatDate(review.created_at) }}</span>
                            </div>
                            <h4 class="text-sm font-medium text-gray-900">{{ review.name }}</h4>
                            <p class="mt-1 text-sm text-gray-600">{{ review.comment }}</p>
                        </div>
                    </div>
                    <div v-else-if="!product.reviews || product.reviews.length === 0" class="text-center py-6">
                        <p class="text-gray-500">У этого товара пока нет отзывов. Будьте первым, кто оставит отзыв!</p>
                    </div>
                </div>
            </div>

            <!-- Похожие товары -->
            <div v-if="relatedProducts && relatedProducts.length" class="mt-8">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Похожие товары</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div v-for="relatedProduct in relatedProducts" :key="relatedProduct.id" class="group relative">
                            <div class="aspect-w-1 aspect-h-1 rounded-lg bg-gray-200 overflow-hidden">
                                <img
                                    :src="relatedProduct.image ? `/storage/${relatedProduct.image}` : '/images/placeholder.jpg'"
                                    :alt="relatedProduct.name_ru"
                                    class="object-center object-cover group-hover:opacity-75 transition-opacity"
                                >
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between">
                                    <h3 class="text-sm text-gray-700">
                                        <Link :href="route('product.show', relatedProduct.slug)">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ relatedProduct.name_ru }}
                                        </Link>
                                    </h3>
                                    <p class="text-sm font-medium text-gray-900">{{ formatCurrency(relatedProduct.price) }}</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">{{ relatedProduct.category.name_ru }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import {
    StarIcon,
    ShoppingCartIcon,
    HeartIcon,
    CheckCircleIcon,
    XCircleIcon,
    PlusIcon,
    MinusIcon
} from '@heroicons/vue/24/solid';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';

const props = defineProps({
    product: Object,
    relatedProducts: Array,
    isInFavorites: Boolean
});

const quantity = ref(1);
const showReviewForm = ref(false);

const reviewForm = useForm({
    product_id: props.product.id,
    rating: 5,
    name: '',
    email: '',
    comment: ''
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' }).format(value);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ru-RU');
};

const increaseQuantity = () => {
    if (quantity.value < props.product.stock) {
        quantity.value++;
    }
};

const decreaseQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const addToCart = () => {
    router.post(route('cart.add'), {
        product_id: props.product.id,
        quantity: quantity.value
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Можно добавить уведомление об успешном добавлении
        }
    });
};

const addToFavorites = () => {
    if (props.isInFavorites) {
        router.delete(route('favorites.remove', props.product.id), {
            preserveScroll: true
        });
    } else {
        router.post(route('favorites.add'), {
            product_id: props.product.id
        }, {
            preserveScroll: true
        });
    }
};

const submitReview = () => {
    reviewForm.post(route('product.review', props.product.slug), {
        preserveScroll: true,
        onSuccess: () => {
            showReviewForm.value = false;
            reviewForm.reset();
        }
    });
};
</script>
