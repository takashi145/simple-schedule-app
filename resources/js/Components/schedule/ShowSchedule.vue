<script setup>
import Modal from '@/Components/Modal.vue';
import { router, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  schedule: Object,
  show: Boolean,
})

const emit = defineEmits(['close']);

const deleteSchedule = () => {
  router.delete(route('schedule.delete', {'schedule' : props.schedule.id }), {
    onBefore: () => confirm('本当に削除してもよろしいですか'),
    onSuccess: () => emit('close'),
    preserveScroll: true
  })
}
</script>

<template>
  <div>
    <Modal 
      closeable=false
      :show="show"
      title="予定詳細"
      @close="emit('close')"
    >
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

        <div class="mb-3">
          <label>重要度</label>
          <div class="text-lg font-bold ml-3">
            <span v-if="schedule.status === 1" class="text-red-500">大</span>
            <span v-if="schedule.status === 2" class="text-yellow-500">中</span>
            <span v-if="schedule.status === 3" class="text-green-500">小</span>
          </div>
        </div>

        <div class="text-end border-t pt-3 space-x-4">
          <Link :href="route('schedule.edit', {'schedule': schedule.id})" as="button" class="text-white bg-indigo-400 hover:bg-indigo-600 px-4 py-2 rounded shadow-lg">編集</Link>
          <button @click="deleteSchedule()" class="text-white bg-red-400 hover:bg-red-600 px-4 py-2 rounded shadow-lg">削除</button>
        </div>
      </div>
    </Modal>
  </div>
</template>