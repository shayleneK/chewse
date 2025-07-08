<script setup>
import TopNav from "../components/TopNav.vue";
</script>
<template>
    <div class="flex min-h-screen flex-col bg-egg">
        <header><TopNav /></header>
        <main>
            <slot />
        </main>
    </div>
</template>
