<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen">
        <div v-if="canLogin" class="fixed top-0 right-0 p-6 text-right">
            <Link
                v-if="$page.props.auth.user"
                :href="route('schedule.index')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Home</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="mt-32">
            <div class="flex justify-center">
                <img src="/images/logo.png" alt="">
            </div>
            <div class="text-center">
                <button class="text-white bg-indigo-400 hover:bg-indigo-600 py-3 px-8 rounded">始める</button>
            </div>
        </div>
    </div>
</template>
