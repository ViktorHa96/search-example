<template>
    <div class="w-full bg-slate-100 shadow-md shadow-black/60 text-black">
        <div class="flex flex-row place-items-center mx-auto">
            <div class="flex justify-center mx-auto place-items-center gap-4 my-3">
                <input @input="onInputChange" v-model="searchInput" class="flex w-56 rounded-md border-0 shadow-inner shadow-black/40" placeholder="Search" type="text" id="search">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M21 21l-6 -6"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['send-search'])

const searchInput = ref()

let timerId: any = null;

const onInputChange = () => {
  // Reset the previous timer
  clearTimeout(timerId);

  // Set a new timer to call sendSearch after 2 seconds
  timerId = setTimeout(() => {
    emit('send-search', searchInput.value);
  }, 1000);
};

</script>

<style scoped>

</style>
