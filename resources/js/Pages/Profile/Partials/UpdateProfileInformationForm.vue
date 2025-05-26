<template>
    <form @submit.prevent="updateProfileInformation" class="bg-white p-4 sm:p-6 shadow sm:rounded-lg">
        <div>
            <InputLabel for="name" value="Имя" />
            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-6">
            <InputLabel for="email" value="Email" />
            <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-6 flex items-center">
            <Button :disabled="form.processing">Сохранить</Button>

            <Transition
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
                class="transition ease-in-out"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 ml-3">Сохранено.</p>
            </Transition>
        </div>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
});

const updateProfileInformation = () => {
    form.post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>
