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
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.address.value') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <PhoneIcon class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-medium text-gray-900">{{ $t('contacts.phone.title') }}</h3>
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.phone.value1') }}</p>
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.phone.value2') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <EnvelopeIcon class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-medium text-gray-900">{{ $t('contacts.email.title') }}</h3>
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.email.value1') }}</p>
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.email.value2') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <ClockIcon class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-medium text-gray-900">{{ $t('contacts.workingHours.title') }}</h3>
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.workingHours.weekdays') }}</p>
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.workingHours.saturday') }}</p>
                                    <p class="mt-1 text-gray-600">{{ $t('contacts.workingHours.sunday') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-base font-medium text-gray-900 mb-4">{{ $t('contacts.socialMedia.title') }}</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-indigo-600">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-indigo-600">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-indigo-600">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-indigo-600">
                                    <span class="sr-only">Telegram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 11.944 0Zm.232 18.818c-.333 0-.678-.051-1.01-.154l-3.005.831.831-3.005a4.077 4.077 0 0 1-.154-1.01 4.075 4.075 0 0 1 4.075-4.075 4.075 4.075 0 0 1 4.075 4.075 4.076 4.076 0 0 1-4.812 3.338Zm0-7.767a3.692 3.692 0 0 0-3.688 3.688c0 .355.064.696.179 1.013l.108.289-.462 1.687 1.687-.462.289.108a3.68 3.68 0 0 0 1.013.179 3.691 3.691 0 0 0 3.688-3.688 3.69 3.69 0 0 0-3.688-3.688Zm2.11 4.7a.982.982 0 0 1-.132.149c-.174.174-.347.283-.521.283-.122 0-.248-.041-.423-.131l-.595-.298c-.5-.25-.988-.592-1.338-.942s-.692-.838-.942-1.338l-.298-.595c-.09-.175-.131-.301-.131-.423 0-.174.109-.347.283-.521a.982.982 0 0 1 .149-.132.707.707 0 0 1 .343-.089c.082 0 .165.025.232.075.075.05.138.125.189.206l.293.478c.066.111.078.211.037.3a.359.359 0 0 1-.066.115.518.518 0 0 1-.082.094 2.19 2.19 0 0 0-.18.206c-.05.066-.04.134.026.21.066.09.197.226.39.39s.3.325.39.39c.076.067.144.076.21.026.053-.03.135-.098.206-.18a.53.53 0 0 1 .094-.082.359.359 0 0 1 .115-.066c.089-.041.189-.029.3.037l.478.293c.081.05.156.114.206.19.05.066.075.149.075.231 0 .131-.03.242-.089.343Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Форма обратной связи -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Напишите нам</h2>

                    <div v-if="status" class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <InputLabel for="name" value="Имя" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.name" class="mt-1" />
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
                                <InputError :message="form.errors.email" class="mt-1" />
                            </div>

                            <div>
                                <InputLabel for="phone" value="Телефон" />
                                <TextInput
                                    id="phone"
                                    v-model="form.phone"
                                    type="tel"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.phone" class="mt-1" />
                            </div>

                            <div>
                                <InputLabel for="subject" value="Тема" />
                                <TextInput
                                    id="subject"
                                    v-model="form.subject"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="form.errors.subject" class="mt-1" />
                            </div>

                            <div>
                                <InputLabel for="message" value="Сообщение" />
                                <Textarea
                                    id="message"
                                    v-model="form.message"
                                    class="mt-1 block w-full"
                                    rows="5"
                                    required
                                />
                                <InputError :message="form.errors.message" class="mt-1" />
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
            <div class="mt-12 bg-white shadow-md rounded-lg overflow-hidden h-96">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.5802220705856!2d37.617696976957386!3d55.75639697987999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a50b315e573%3A0xa886bf5a3d9b2e68!2z0JzQvtGB0LrQvtCy0YHQutC40Lkg0JrRgNC10LzQu9GM!5e0!3m2!1sru!2sru!4v1708280269317!5m2!1sru!2sru"
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

const props = defineProps({
    status: String
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: ''
});

const submit = () => {
    form.post(route('contact.send'), {
        onSuccess: () => form.reset()
    });
};
</script>
