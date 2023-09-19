<template>
    <div  class="relative w-full min-h-screen">
        <div class="mt-20 place-items-center justify-center">
            <div class="flex flex-col gap-6">
                <h2 class="font-bold text-xl">{{ post.title }}</h2>
                <p>{{ post.description }}</p>
                <em>{{ post.created_at }}</em>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps <{
    post: any
}>()

</script>

<style scoped>

</style>
