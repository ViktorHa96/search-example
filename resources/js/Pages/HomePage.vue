<template>
<div class="relative w-full min-h-screen">
        <NavBar @send-search="getSearch($event)"/>
        <div v-if="posts.length > 0" class="absolute top-20 left-[50%] translate-x-[-50%] w-1/3">
            <ul>
                <li class="py-2 px-4 border-2 rounded-lg mb-2 hover:bg-gray-200 duration-100 " v-for="item in posts" :key="item.id">
                    <Link class="flex flex-col gap-2" :href="route('show.posts', {type: item.type, id: item.id})">
                        <h2 class="font-bold" v-html="item.name"></h2>
                        <!-- Použitie v-html pre zvýraznený popis -->
                        <em class="text-xm"> {{ item.type }}</em>
                    </Link>
                </li>
            </ul>

        </div>
    </div>
</template>

<script setup lang="ts">
import NavBar from '@/Components/NavBar.vue';
import { ref } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

const searchContent = ref()
const posts = ref<any>([])

const getSearch = (event:any) => {
    searchContent.value = event
    getPosts()
}

const getPosts = async () => {
    const response = await axios.get(route('get.posts', {search: searchContent.value}))
    console.log(response.data)
    posts.value = response.data.posts
}

</script>

<style scoped>
.highlight {
    font-weight: bold;
    text-decoration: underline;
}

</style>
