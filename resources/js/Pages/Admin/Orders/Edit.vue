<template>
    <AdminLayout :title="`Редактирование заказа #${order.id}`">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Редактирование заказа #{{ order.id }}</h1>
                <Link :href="route('admin.orders.index')" class="text-indigo-600 hover:text-indigo-900">
                    Назад к списку
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <InputLabel for="first_name" value="Имя клиента" />
                            <TextInput
                                id="first_name"
                                v-model="form.first_name"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.first_name" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="last_name" value="Фамилия клиента" />
                            <TextInput
                                id="last_name"
                                v-model="form.last_name"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.last_name" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <InputLabel for="phone" value="Телефон" />
                            <TextInput
                                id="phone"
                                v-model="form.phone"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.phone" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <InputLabel for="address" value="Адрес доставки" />
                            <TextInput
                                id="address"
                                v-model="form.address"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.address" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="status" value="Статус заказа" />
                            <SelectInput
                                id="status"
                                v-model="form.status"
                                class="mt-1 block w-full"
                                required
                            >
                                <option value="pending">Ожидает обработки</option>
                                <option value="processing">В обработке</option>
                                <option value="shipped">Отправлен</option>
                                <option value="delivered">Доставлен</option>
                                <option value="completed">Завершен</option>
                                <option value="cancelled">Отменен</option>
                                <option value="refunded">Возвращен</option>
                            </SelectInput>
                            <InputError :message="form.errors.status" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <InputLabel for="notes" value="Комментарий к заказу" />
                        <Textarea
                            id="notes"
                            v-model="form.notes"
                            class="mt-1 block w-full"
                            rows="4"
                        />
                        <InputError :message="form.errors.notes" class="mt-2" />
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
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/Button.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import Textarea from '@/Components/Textarea.vue';

const props = defineProps({
    order: Object
});

const form = useForm({
    status: props.order.status,
    first_name: props.order.first_name,
    last_name: props.order.last_name,
    email: props.order.email,
    phone: props.order.phone,
    address: props.order.address,
    notes: props.order.notes,
    _method: 'PUT'
});

const submit = () => {
    form.post(route('admin.orders.update', props.order.id), {
        preserveScroll: true,
        onSuccess: () => {
            router.visit(route('admin.orders.index'));
        }
    });
};

const cancel = () => {
    router.visit(route('admin.orders.index'));
};
</script>
