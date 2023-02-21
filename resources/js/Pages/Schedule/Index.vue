<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { formatDate } from '@/date';
import ShowSchedule from '@/Components/schedule/ShowSchedule.vue';

const props = defineProps({
  schedules: Object,
  prev: Date,
  next: Date,
})

const now = formatDate(new Date());

const show = ref(false);
const schedule = ref({});

const from = ref(now);

const changeDate = () => {
  router.get('/schedule', { from: from.value }, { preserveState: true });
}

const prev = () => {
  router.get('/schedule', { from: props.prev }, { preserveState: true });
}

const next = () => {
  router.get('/schedule', { from: props.next }, { preserveState: true });
}

const show_schedule = value => {
  schedule.value = value;
  show.value = true;
}

</script>

<template>
    <Head title="ScheduleList" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">ScheduleList</h2>
        </template>

        <div class="py-4 mb-8">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="text-end mx-3">
                  <Link :href="route('schedule.create')" class="text-blue-400 underline">予定を追加</Link>
                </div>
                <div class="flex justify-between mx-4 mt-4">
                  <button @click="prev" class="underline px-4 py-3 rounded">←Prev</button>
                  <button @click="next" class="underline px-4 py-3 rounded">Next→</button>
                </div>
                <div class="overflow-hidden shadow-sm sm:rounded-lg px-3 md:px-8 pb-12">
                  <details v-for="(items, key) in schedules" :key="key" class="border-b mb-8 shadow-lg p-3 bg-gray-100" open>
                    <summary class="flex justify-between cursor-pointerpb-3 pb-3 cursor-pointer">
                      <div class="text-lg">
                        {{ key }} <span v-if="now === key" class="bg-green-400 text-white p-1 text-sm rounded">Today</span>
                      </div>
                      <div class="text-gray-700">
                        {{ items.length }} tasks
                      </div>
                    </summary>
                    <div class="border-t-2 p-3 bg-gray-50">
                      <button v-for="value in items" :key="value.id" @click="show_schedule(value)" class="flex flex-col md:flex-row justify-between w-full mb-6 text-xs md:text-sm text-start hover:cursor-pointer hover:underline border-b pb-3">
                        <div class="flex items-center">
                          <span v-if="value.status === 1" class="mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-500">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                          </span>
                          <span v-if="value.status === 2" class="mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-yellow-500">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                          </span>
                          <span v-if="value.status === 3" class="mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-500">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                          </span>
                          {{ value.title }}  
                        </div>
                      </button>
                    </div>
                  </details>
                </div>
            </div>
        </div>

        <ShowSchedule @close="show=false" :show="show" :schedule="schedule" />

        <div class="p-3 w-full fixed bottom-0 flex flex-col justify-center bg-gray-300 border-t-4">
          <label for="" class="mx-auto">日付指定: </label>
          <input type="date" @change="changeDate()" v-model="from" class="w-full md:w-2/3 lg:w-1/3 mb-3 rounded shadow mx-auto border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
    </AuthenticatedLayout>
</template>
