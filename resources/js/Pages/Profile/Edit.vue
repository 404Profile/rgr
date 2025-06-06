<template>
    <Head title="Профиль" />

    <MainLayout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <UpdateProfileInformationForm :user="$page.props.auth.user" />

            <SectionBorder />

            <UpdatePasswordForm />

            <SectionBorder />


            <DeleteUserForm />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import SectionBorder from "@/Components/SectionBorder.vue";
</script>
