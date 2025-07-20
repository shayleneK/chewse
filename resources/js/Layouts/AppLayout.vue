<script setup>
import TopNav from "../components/TopNav.vue";
import Chatbot from "@/Components/Chatbot.vue";
import ReviewConfidenceTester from "@/components/ReviewConfidenceTester.vue";
import { selectedRecipe } from "@/composables/chatbotStore";
import { watch } from "vue";
 

watch(selectedRecipe, (newRecipe) => {
    console.log("Updated selected recipe for chatbot:", newRecipe);
});

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
