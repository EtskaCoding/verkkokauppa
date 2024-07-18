<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    product: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tilaa</h2>
        </template>

        <div class="py-12 grid grid-cols-1 justify-items-center">
            <div class="grid grid-cols-1 justify-items-center max-w-7xl mx-auto sm:px-6 lg:px-8 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <div class="justify-center">
                    {{ product.name}}
                </div>
                <div class="justify-center">
                    {{ product.price }}€/kk
                </div>
            </div>
            <Link class="mt-6 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" method="post" :data="{ product: product.id }" :href="route('product.order')">Tilaa</Link>
        </div>
    </AuthenticatedLayout>
</template>
