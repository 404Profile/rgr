<template>
    <form @submit.prevent="updatePassword" class="bg-white p-4 sm:p-6 shadow sm:rounded-lg">
        <div>
            <InputLabel for="current_password" value="Текущий пароль" />
            <TextInput
                id="current_password"
                ref="currentPasswordInput"
                v-model="form.current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password"
            />
            <InputError :message="form.errors.current_password" class="mt-2" />
        </div>

        <div class="mt-6">
            <InputLabel for="password" value="Новый пароль" />
            <TextInput
                id="password"
                v-model="form.password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6">
            <InputLabel for="password_confirmation" value="Подтверждение пароля" />
            <TextInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <InputError :message="form.errors.password_confirmation" class="mt-2" />
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

const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password_confirmation) {
                form.reset('password', 'password_confirmation');
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>
