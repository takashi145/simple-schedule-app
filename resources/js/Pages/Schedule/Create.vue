<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import InputError from '@/Components/InputError.vue';
import { formatDateTime } from '@/date';

const props = defineProps({
  errors: Object,
  date: Date,
})

const form = useForm({
  title: '',
  description: '',
  deadline: props.date? formatDateTime(new Date(props.date)) : formatDateTime(new Date()),
  status: 1,
})

const submit = () => {
  form.post(route('schedule.store'));
}
</script>

<template>
    <Head title="AddSchedule" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">AddSchedule</h2>
        </template>

        <div class="mb-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="m-3">
                <Link :href="route('schedule.index')" class="text-blue-400 hover:text-blue-600 hover:underline">←戻る</Link>
              </div>
                <div class="overflow-hidden mt-12">
                  <div class="text-gray-600 body-font relative">
                    <form @submit.prevent="submit" class="lg:w-1/2 md:w-3/4 mx-auto bg-gray-100 md:rounded-lg p-8 flex flex-col md:ml-auto w-full md:mt-0 relative z-10 shadow-md">
                      <h2 class="text-gray-900 text-lg mb-4 font-medium title-font border-b pb-3">予定追加</h2>
                      <div class="relative mb-4">
                        <label for="title" class="leading-7 text-sm text-gray-600">予定タイトル<span class="text-red-400">*</span></label>
                        <input type="text" v-model="form.title" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <InputError :message="errors.title" />
                      </div>
                      <div class="relative mb-4">
                        <label for="description" class="leading-7 text-sm text-gray-600">予定詳細</label>
                        <textarea v-model="form.description" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        <InputError :message="errors.description" />
                      </div>
                      <div class="relative mb-4">
                        <label for="title" class="leading-7 text-sm text-gray-600">期限<span class="text-red-400">*</span></label>
                        <input type="datetime-local" v-model="form.deadline" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <InputError :message="errors.deadline" />
                      </div>
                      <div class="relative mb-6">
                        <label for="title" class="leading-7 text-sm text-gray-600">重要度<span class="text-red-400">*</span></label>
                        <select v-model="form.status" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          <option value="1">大</option>
                          <option value="2">中</option>
                          <option value="3">小</option>
                        </select>
                      </div>
                      <button 
                        type="submit" 
                        :disabled="!form.title || !form.deadline || !form.status"
                        :class="[!form.title || !form.deadline || !form.status ? 'bg-gray-300 shadow-inner' : 'bg-indigo-500 hover:bg-indigo-600 shadow-lg']"
                        class="text-white border-0 py-2 px-6 focus:outline-none rounded text-lg"
                      >
                        追加
                      </button>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
