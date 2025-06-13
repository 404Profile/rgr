<template>
    <Head title="Контакты" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 text-center mb-12">{{ $t('contacts.title') }}</h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Контактная информация -->
                <div>
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ $t('contacts.ourContacts') }}</h2>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <MapPinIcon class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-medium text-gray-900">{{ $t('contacts.address.title') }}</h3>
                                    <p class="mt-1 text-gray-600">{{ contact.address }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <PhoneIcon class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-medium text-gray-900">{{ $t('contacts.phone.title') }}</h3>
                                    <p class="mt-1 text-gray-600">{{ contact.phone }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <EnvelopeIcon class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-medium text-gray-900">{{ $t('contacts.email.title') }}</h3>
                                    <p class="mt-1 text-gray-600">{{ contact.email }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <ClockIcon class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-medium text-gray-900">{{ $t('contacts.workingHours.title') }}</h3>
                                    <p class="mt-1 text-gray-600 whitespace-pre-line">{{ contact.working_hours }}</p>
                                </div>
                            </div>
                        </div>

                        <div v-if="contact?.social_links && Object.keys(contact.social_links).length" class="mt-8">
                            <h3 class="text-base font-medium text-gray-900 mb-4">{{ $t('contacts.socialMedia.title') }}</h3>
                            <div class="flex flex-wrap gap-4">
                                <a
                                    v-for="(url, name) in contact.social_links"
                                    :key="name"
                                    :href="url"
                                    target="_blank"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-gray-800 hover:text-indigo-600 transition-colors"
                                >
                                    {{ name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Форма обратной связи -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ $t('contacts.contactForm.title') }}</h2>

                    <form @submit.prevent="validateAndSubmit">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <InputLabel for="name" :value="$t('contacts.contactForm.name')" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="errors.name" class="mt-1" />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="errors.email" class="mt-1" />
                            </div>

                            <div>
                                <InputLabel for="phone" :value="$t('contacts.contactForm.phone')" />
                                <TextInput
                                    id="phone"
                                    v-model="form.phone"
                                    type="tel"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="errors.phone" class="mt-1" />
                            </div>

                            <div>
                                <InputLabel for="subject" :value="$t('contacts.contactForm.theme')" />
                                <TextInput
                                    id="subject"
                                    v-model="form.subject"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="errors.subject" class="mt-1" />
                            </div>

                            <div>
                                <InputLabel for="message" :value="$t('contacts.contactForm.message')" />
                                <Textarea
                                    id="message"
                                    v-model="form.message"
                                    class="mt-1 block w-full"
                                    rows="5"
                                    required
                                />
                                <InputError :message="errors.message" class="mt-1" />
                            </div>

                            <div>
                                <Button
                                    type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white"
                                    :disabled="form.processing"
                                >
                                    {{ $t('contacts.contactForm.submit') }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Карта -->
            <div v-if="contact?.map_latitude && contact?.map_longitude" class="mt-12 bg-white shadow-md rounded-lg overflow-hidden h-96">
                <iframe
                    :src="`https://maps.google.com/maps?q=${contact.map_latitude},${contact.map_longitude}&z=15&output=embed`"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { MapPinIcon, PhoneIcon, EnvelopeIcon, ClockIcon } from '@heroicons/vue/24/outline';
import MainLayout from '@/Layouts/MainLayout.vue';
import Button from '@/Components/Button.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Textarea from '@/Components/Textarea.vue';
import { ref } from 'vue';

const props = defineProps({
    contact: Object,
    status: String
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
});

const errors = ref({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
});

const validateForm = () => {
    Object.keys(errors.value).forEach(key => {
        errors.value[key] = '';
    });

    let isValid = true;

    const nameRegex = /^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/;
    if (!nameRegex.test(form.name)) {
        errors.value.name = 'Введите полное ФИО в формате "Фамилия Имя Отчество"';
        isValid = false;
    }

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(form.email)) {
        errors.value.email = 'Введите корректный email адрес';
        isValid = false;
    }

    if (form.phone) {
        const phoneRegex = /^\d{11}$/;
        if (!phoneRegex.test(form.phone)) {
            errors.value.phone = 'Телефон должен содержать 11 цифр без символов +, - и пробелов';
            isValid = false;
        }
    }

    if (form.subject.length <= 3) {
        errors.value.subject = 'Тема должна содержать более 3 символов';
        isValid = false;
    }

    if (!form.message.trim()) {
        errors.value.message = 'Введите текст сообщения';
        isValid = false;
    }

    return isValid;
};

const validateAndSubmit = () => {
    if (validateForm()) {
        form.post(route('contact.send'), {
            onSuccess: () => form.reset()
        });
    }
};
</script>
