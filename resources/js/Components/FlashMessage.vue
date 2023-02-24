<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref, watch } from 'vue';

onMounted(() => {
  show.value = true;
  setTimeout(() => {
    show.value = false;
  }, 5000);
})

const flash = computed(() => usePage().props.flash);
const show = ref(false);

watch(flash, () => {
  if(flash.value.message) {
    show.value = true;
    setTimeout(() => {
      show.value = false;
    }, 5000);
  }
});

</script>
<template>
  <transition
      enter-active-class="ease-out duration-500"
      enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      enter-to-class="opacity-100 translate-y-0 sm:scale-100"
      leave-active-class="ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0 sm:scale-100"
      leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
  >
    <div 
      v-if="show && flash.message"
      @click="flash.message = null"
      :class="[flash.status === 'success' ? 'bg-green-400' : 'bg-red-400']"
      class="text-white w-full lg:w-2/3 mx-auto text-center rounded py-2 lg:mt-3 cursor-pointer"
    >
      {{ flash.message }}
    </div>
  </transition>
</template>
