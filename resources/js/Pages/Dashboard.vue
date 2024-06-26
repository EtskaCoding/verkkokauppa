<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    products: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ul class="grid grid-cols-1 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    <li
                        v-for="product in products"
                        :key="product.id"
                        class="relative bg-gray-400 hover:bg-gray-600  rounded-md min-h-[7rem]">
                        <Link :href="route('product.show', {id: product.id})"
                              class="text-gray-900 hover:text-gray-900 text-lg font-bold absolute inset-0">
                            {{ product.name }}
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
