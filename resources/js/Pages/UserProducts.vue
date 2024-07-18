<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    user_products: Array,
});
</script>

<template>
    <Head title="Tuotteet" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tuotteet</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ul class="grid grid-cols-1 gap-4">
                    <li
                        v-for="user_product in user_products"
                        :key="user_product.id"
                        class="relative hover:bg-opacity-85 rounded-md">
                        <div class="grid grid-cols-4 gap-4">
                            <div class="p-4 rounded-lg">
                                <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{ user_product.name }}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Tuote</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
