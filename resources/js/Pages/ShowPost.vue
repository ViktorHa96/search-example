<template>
    <div  class="relative w-full min-h-screen">
        <div class="mt-20 flex flex-col place-items-center justify-center gap-6">
            <div v-if="type == 'kategória' || type == 'tag'"  v-for="post in posts" :key="post.id" class="flex flex-col gap-6">
                <h2 class="font-bold text-xl">{{ post.post.title }}</h2>
                <p>{{ post.post.description }}</p>
                <em>{{ post.post.created_at }}</em>
                <div class="flex flex-row gap-3 place-items-center justify-center">
                    <div v-for="tag in post.tags" :key="tag" class="flex flex-row">
                    <h2 class="py-1 px-2 bg-black text-white rounded-md">{{ tag }}</h2>
                </div>
                </div>
                <h2 class="flex place-items-center justify-center bg-red-400">{{post.category }}</h2>
            </div>

            <div v-if="type == 'príspevok'"  class="flex flex-col gap-6">
                <h2 class="font-bold text-xl">{{ posts.post.title }}</h2>
                <p>{{ posts.post.description }}</p>
                <em>{{ posts.post.created_at }}</em>
                <div class="flex flex-row gap-3 place-items-center justify-center">
                    <div v-for="tag in posts.tags" :key="tag" class="flex flex-row">
                    <h2 class="py-1 px-2 bg-black text-white rounded-md">{{ tag }}</h2>
                </div>
                </div>
                <h2 class="flex place-items-center justify-center bg-red-400">{{posts.category }}</h2>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps <{
    type: any
    posts: any
}>()

</script>

<style scoped>

</style>
