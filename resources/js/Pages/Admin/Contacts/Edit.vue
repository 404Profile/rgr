<template>
    <AdminLayout title="Редактирование контактной информации">
        <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Редактирование контактной информации</h1>
                <Link :href="route('admin.contacts.index')" class="text-indigo-600 hover:text-indigo-900">
                    Назад
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
                            <InputLabel for="address" value="Адрес" />
                            <Textarea
                                id="address"
                                v-model="form.address"
                                class="mt-1 block w-full"
                                rows="3"
                                required
                            />
                            <InputError :message="form.errors.address" class="mt-2" />
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
                            <InputLabel for="working_hours" value="Часы работы" />
                            <TextInput
                                id="working_hours"
                                v-model="form.working_hours"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Например: Пн-Пт: 9:00-18:00"
                            />
                            <InputError :message="form.errors.working_hours" class="mt-2" />
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
                            Сохранить
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import Button from '@/Components/Button.vue';

const props = defineProps({
    contact: Object,
});

// Преобразуем объект social_links в массив для удобства редактирования
const socialLinks = ref([]);

onMounted(() => {
    if (props.contact && props.contact.social_links) {
        socialLinks.value = Object.entries(props.contact.social_links).map(([name, url]) => ({
            name,
            url
        }));
    }

    if (socialLinks.value.length === 0) {
        // Добавим пустую строку, если нет социальных сетей
        addSocialLink();
    }
});

const form = useForm({
    phone: props.contact?.phone || '',
    email: props.contact?.email || '',
    address: props.contact?.address || '',
    map_latitude: props.contact?.map_latitude || '',
    map_longitude: props.contact?.map_longitude || '',
    working_hours: props.contact?.working_hours || '',
    social_links: props.contact?.social_links || {},
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
    form.post(route('admin.contacts.update'), {
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
