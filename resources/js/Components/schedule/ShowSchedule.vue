<script setup>
import Modal from '@/Components/Modal.vue';
import { defineProps } from 'vue';

const props = defineProps({
  schedule: Object,
})
</script>

<template>
  <div class="m-3 p-4">
    <div class="mb-6">
      <label class="">期限</label>
      <p class="bg-gray-100 rounded p-2">{{ schedule.deadline }}</p>
    </div>

    <div class="mb-6">
      <label class="">予定タイトル</label>
      <h4 class="text-md bg-gray-100 p-1 rounded">{{ schedule.title }}</h4>
    </div>

    <div class="mb-6">
      <label>予定詳細</label>
      <p class="bg-gray-100 rounded p-3 text-sm space-y-3 h-48">{{ schedule.description }}</p>
    </div>

    <div>
      <label>重要度</label>
      <div class="text-lg font-bold ml-3">
        <span v-if="schedule.status === 1" class="text-red-500">大</span>
        <span v-if="schedule.status === 2" class="text-yellow-500">中</span>
        <span v-if="schedule.status === 3" class="text-green-500">小</span>
      </div>
    </div>
  </div>
</template>