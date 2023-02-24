<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { formatDate, formatTime } from '@/date';
import ShowSchedule from '@/Components/schedule/ShowSchedule.vue';
import StatusComponent from '@/Components/schedule/StatusComponent.vue';

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
                  <button @click="prev" class="underline px-4 py-3 rounded">←前</button>
                  <button @click="next" class="underline px-4 py-3 rounded">次→</button>
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
                        <div class="w-full flex flex-col">
                          <div class="text-gray-700 underline mb-2">
                            {{ formatTime(new Date(value.deadline)) }}
                          </div>
                          <div class="flex items-center ml-3">
                            <StatusComponent :status="value.status" />
                            {{ value.title }}  
                          </div>
                        </div>
                      </button>
                    </div>
                    <div class="text-end">
                      <Link 
                        :href="route('schedule.create')" 
                        :data="{date: key}"
                        class="text-sm text-blue-400 hover:underline"
                      >
                        追加
                      </Link>
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
