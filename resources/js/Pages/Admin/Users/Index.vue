<template>
    <AdminLayout title="Пользователи">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-4 sm:px-0">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">Пользователи</h1>
                    <Link :href="route('admin.users.create')" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Добавить пользователя
                    </Link>
                </div>

                <!-- Сообщение об успехе -->
                <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                </div>

                <!-- Сообщение об ошибке -->
                <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $page.props.flash.error }}</span>
                </div>

                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Имя</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Роль</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ user.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span :class="{
                                        'bg-green-100 text-green-800': user.role === 'admin',
                                        'bg-blue-100 text-blue-800': user.role === 'manager',
                                        'bg-gray-100 text-gray-800': user.role === 'user'
                                    }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                        {{ getRoleName(user.role) }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <Link :href="route('admin.users.edit', user.id)" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $t('admin.edit') }}
                                    </Link>
                                    <button @click="confirmDelete(user.id, user.id === $page.props.auth.user.id)"
                                            class="text-red-600 hover:text-red-900"
                                            :class="{ 'opacity-50 cursor-not-allowed': user.id === $page.props.auth.user.id }">
                                        {{ $t('admin.delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <Pagination :links="users.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    users: Object,
});

const getRoleName = (role) => {
    const roles = {
        'admin': 'Администратор',
        'user': 'Пользователь'
    };
    return roles[role] || role;
};

const confirmDelete = (id, isSelf) => {
    if (isSelf) {
        alert('Вы не можете удалить самого себя');
        return;
    }

    if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
        router.delete(route('admin.users.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>
