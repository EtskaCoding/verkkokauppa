<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    invoices: Array,
});
</script>

<template>
    <Head title="Laskut" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Laskut</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash.message" :class="$page.props.flash.status">
                    <div v-if="$page.props.flash.status === 'success'">
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            {{ $page.props.flash.message }}
                        </div>
                    </div>
                    <div v-else>
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            {{ $page.props.flash.message }}
                        </div>
                    </div>
                </div>
                {{ $page.props.flash.status }}
                <ul class="grid grid-cols-1 gap-4">
                    <li
                        v-for="invoice in invoices"
                        :key="invoice.id"
                        :class="invoice.color"
                        class="relative hover:bg-opacity-85 rounded-md">
                        <div v-if="invoice.paid === 1">
                            <div class="p-4 rounded-lg">
                                <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">Maksettu</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Tila</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{ invoice.price }}€</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Hinta</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{ invoice.due_date }}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Eräpäivä</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <div v-else>
                            <div class="p-4 rounded-lg">
                                <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">Odottaa maksua</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Tila</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{ invoice.price }}€</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Hinta</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{ invoice.due_date }}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Eräpäivä</dd>
                                    </div>
                                    <div class="xl:col-start-6 flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">
                                            <Link class="inline-flex items-center px-8 py-4 border border-white rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-white-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" method="post" :data="{ invoice: invoice.id }" :href="route('invoice.pay')">Maksa</Link>
                                        </dt>
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
