<script setup>
import TopNav from "../components/TopNav.vue";
import Chatbot from "@/Components/Chatbot.vue";
import ReviewConfidenceTester from "@/components/ReviewConfidenceTester.vue";
</script>
<template>
    <div class="flex min-h-screen flex-col bg-gray-100">
        <header><TopNav /></header>
        <main>
            <slot />
        </main>
        <Chatbot />
        <ReviewConfidenceTester />
    </div>
</template>
