<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
  schedules: Object,
})

const from = ref(null);

const changeDate = () => {
  router.get('/schedule', { from: from.value }, { preserveState: true })
}
</script>

<template>
    <Head title="ScheduleList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ScheduleList</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                  <input type="date" v-model="from" @change="changeDate()">
                  <ul v-for="(items, key) in schedules" :key="key" class="border-b my-3">
                    {{ key }}
                    <li v-for="value in items" :key="value.id" class="m-3">
                      - {{ value.title }}
                    </li>
                  </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
