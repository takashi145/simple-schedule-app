<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { formatDate } from '@/formatDate';
import ShowSchedule from '@/Components/schedule/ShowSchedule.vue';
import Modal from '@/Components/Modal.vue';

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

        <div class="py-12 mb-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between mx-8 mb-3">
                  <button @click="prev" class="hover:underline">Prev</button>
                  <button @click="next" class="hover:underline">Next</button>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:p-8">
                  <details v-for="(items, key) in schedules" :key="key" class="border-b my-8 shadow-lg p-3 bg-gray-100" open>
                    <summary class="flex justify-between cursor-pointerpb-3 pb-3 cursor-pointer">
                      <div class="text-lg">
                        {{ key }} <span v-if="now === key" class="bg-green-400 text-white p-1 text-sm rounded">Today</span>
                      </div>
                      <div class="text-gray-700">
                        {{ items.length }} tasks
                      </div>
                    </summary>
                    <div class="border-t-2 p-3 bg-gray-50">
                      <button v-for="value in items" :key="value.id" @click="show_schedule(value)" class="flex mb-6 text-sm text-start hover:cursor-pointer hover:underline">
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
                      </button>
                    </div>
                  </details>
                </div>
            </div>
        </div>

        <Modal 
          :show="show" 
          @close="show = false" 
          title="予定詳細"
        >
          <ShowSchedule :schedule="schedule" />
        </Modal>

        <div class="p-3 w-full fixed bottom-0 bg-gray-300">
          <label for="">開始時刻指定: </label>
          <input type="date" @change="changeDate()" class="w-full mb-3">
        </div>
    </AuthenticatedLayout>
</template>
