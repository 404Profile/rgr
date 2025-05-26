<template>
    <AdminLayout title="Создание контактной информации">
        <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Создание контактной информации</h1>
                <Link :href="route('admin.contacts.index')" class="text-indigo-600 hover:text-indigo-900">
                    Назад к списку
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Телефон -->
                        <div>
                            <InputLabel for="phone" value="Телефон" />
                            <TextInput
                                id="phone"
                                v-model="form.phone"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.phone" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <!-- Адрес (RU) -->
                        <div class="md:col-span-2">
                            <InputLabel for="address_ru" value="Адрес (RU)" />
                            <Textarea
                                id="address_ru"
                                v-model="form.address_ru"
                                class="mt-1 block w-full"
                                rows="3"
                                required
                            />
                            <InputError :message="form.errors.address_ru" class="mt-2" />
                        </div>

                        <!-- Адрес (EN) -->
                        <div class="md:col-span-2">
                            <InputLabel for="address_en" value="Адрес (EN)" />
                            <Textarea
                                id="address_en"
                                v-model="form.address_en"
                                class="mt-1 block w-full"
                                rows="3"
                                required
                            />
                            <InputError :message="form.errors.address_en" class="mt-2" />
                        </div>

                        <!-- Координаты карты -->
                        <div>
                            <InputLabel for="map_latitude" value="Широта" />
                            <TextInput
                                id="map_latitude"
                                v-model="form.map_latitude"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Например: 55.7558"
                            />
                            <InputError :message="form.errors.map_latitude" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="map_longitude" value="Долгота" />
                            <TextInput
                                id="map_longitude"
                                v-model="form.map_longitude"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Например: 37.6173"
                            />
                            <InputError :message="form.errors.map_longitude" class="mt-2" />
                        </div>

                        <!-- Часы работы (RU) -->
                        <div>
                            <InputLabel for="working_hours_ru" value="Часы работы (RU)" />
                            <TextInput
                                id="working_hours_ru"
                                v-model="form.working_hours_ru"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Например: Пн-Пт: 9:00-18:00"
                            />
                            <InputError :message="form.errors.working_hours_ru" class="mt-2" />
                        </div>

                        <!-- Часы работы (EN) -->
                        <div>
                            <InputLabel for="working_hours_en" value="Часы работы (EN)" />
                            <TextInput
                                id="working_hours_en"
                                v-model="form.working_hours_en"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Например: Mon-Fri: 9:00-18:00"
                            />
                            <InputError :message="form.errors.working_hours_en" class="mt-2" />
                        </div>
                    </div>

                    <!-- Социальные сети -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Социальные сети</h3>

                        <div v-for="(link, index) in socialLinks" :key="index" class="flex items-start space-x-2 mb-3">
                            <div class="w-1/3">
                                <TextInput
                                    v-model="link.name"
                                    type="text"
                                    class="block w-full"
                                    placeholder="Название (например, Facebook)"
                                />
                            </div>
                            <div class="flex-1">
                                <TextInput
                                    v-model="link.url"
                                    type="url"
                                    class="block w-full"
                                    placeholder="URL (например, https://facebook.com/mypage)"
                                />
                            </div>
                            <div>
                                <button
                                    type="button"
                                    @click="removeSocialLink(index)"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="addSocialLink"
                            class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Добавить социальную сеть
                        </button>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <Button
                            type="button"
                            class="mr-3"
                            @click="cancel"
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
import { ref, watch } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import Button from '@/Components/Button.vue';

// Массив для социальных сетей
const socialLinks = ref([{ name: '', url: '' }]);

// Форма для создания контактной информации
const form = useForm({
    phone: '',
    email: '',
    address_ru: '',
    address_en: '',
    map_latitude: '',
    map_longitude: '',
    working_hours_ru: '',
    working_hours_en: '',
    social_links: {},
});

// Обновляем social_links в форме при изменении массива socialLinks
watch(socialLinks, () => {
    const links = {};
    socialLinks.value.forEach(link => {
        if (link.name && link.url) {
            links[link.name] = link.url;
        }
    });
    form.social_links = links;
}, { deep: true });

const addSocialLink = () => {
    socialLinks.value.push({ name: '', url: '' });
};

const removeSocialLink = (index) => {
    socialLinks.value.splice(index, 1);
};

const submit = () => {
    form.post(route('admin.contacts.store'), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('admin.contacts.index'));
        },
    });
};

const cancel = () => {
    router.visit(route('admin.contacts.index'));
};
</script>
