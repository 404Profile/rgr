<template>
    <section class="space-y-6 bg-white p-4 sm:p-6 shadow sm:rounded-lg">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Удаление аккаунта</h2>
            <p class="mt-1 text-sm text-gray-600">
                После удаления вашего аккаунта все его ресурсы и данные будут удалены без возможности восстановления.
                Перед удалением аккаунта, пожалуйста, сохраните любые данные или информацию, которые вы хотите сохранить.
            </p>
        </header>

        <Button variant="danger" @click="confirmUserDeletion">Удалить аккаунт</Button>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Вы уверены, что хотите удалить свой аккаунт?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    После удаления вашего аккаунта все его ресурсы и данные будут удалены без возможности восстановления.
                    Пожалуйста, введите свой пароль для подтверждения.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Пароль" class="sr-only" />
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="Пароль"
                        @keyup.enter="deleteUser"
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <Button variant="secondary" @click="closeModal">Отмена</Button>
                    <Button
                        variant="danger"
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Удалить аккаунт
                    </Button>
                </div>
            </div>
        </Modal>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>
