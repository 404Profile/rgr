<template>
    <AdminLayout title="Управление контактами">
        <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Контактная информация</h1>
                <Link :href="route('admin.contacts.create')" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Добавить новый контакт
                </Link>
            </div>

            <!-- Флеш-сообщение об успехе -->
            <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ $page.props.flash.success }}
            </div>

            <div v-if="contacts && contacts.length > 0" class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Телефон</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Адрес (RU)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="contact in contacts" :key="contact.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ contact.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ contact.phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ contact.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ truncateText(contact.address_ru, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <Link :href="route('admin.contacts.edit', contact.id)" class="text-indigo-600 hover:text-indigo-900">
                                    Редактировать
                                </Link>
                                <button @click="confirmDelete(contact.id)" class="text-red-600 hover:text-red-900">
                                    Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="bg-white shadow-md rounded-lg overflow-hidden p-6 text-center">
                <p class="text-gray-500">Контактная информация не настроена.</p>
                <Link :href="route('admin.contacts.create')" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Добавить контактную информацию
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    contacts: Object,
});

function truncateText(text, maxLength) {
    if (!text) return '';
    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

function confirmDelete(id) {
    if (confirm('Вы уверены, что хотите удалить этот контакт?')) {
        router.delete(route('admin.contacts.destroy', id));
    }
}
</script>
