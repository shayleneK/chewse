<script setup>
import { useModal } from "@/composables/useModal";
import { usePage } from "@inertiajs/vue3";
import { Head, router } from "@inertiajs/vue3";
import axios from "axios";
import OnboardingModal from "@/components/modals/OnboardingModal.vue";
import { ref, onMounted } from "vue";

const { activeModal, showModal, closeModal } = useModal();
const showOnboardingModal = ref(false);
const user = usePage().props.auth.user;

defineProps({
    recipes: Array,
});

onMounted(() => {
    if (user.has_onboarded === false) {
        showModal("onboarding");
    }
});

function startRecipe(id) {
    router.visit(`/Recipe/${id}/show`);
}
</script>
<template>
    <div class="flex flex-col p-5 items-center">
        <h1 class="font-bold mb-4 text-pink-500 text-4xl">Recipes</h1>
        <!-- Card -->
        <div
            v-for="recipe in recipes"
            :key="recipe.id"
            class="bg-white mb-8 rounded-lg shadow-md flex w-3/4"
        >
            <img :src="recipe.image" alt="" class="w-1/3 h-auto rounded" />
            <div class="flex flex-col p-4 gap-4 w-full">
                <div class="flex">
                    <h2 class="text-xl font-semibold">{{ recipe.name }}</h2>
                    <button
                        class="ml-auto px-4 py-2 bg-pink-500 hover:bg-pink-700 transition-colors text-white rounded"
                        @click="startRecipe(recipe.id)"
                    >
                        Start Recipe
                    </button>
                </div>
                <p class="mb-2 text-gray-600">{{ recipe.description }}</p>
                <h1 class="font-bold">Ingredients</h1>
                <ol class="list-decimal list-inside space-y-1">
                    <li
                        v-for="(ingredient, index) in recipe.ingredients"
                        :key="index"
                        class="text-sm text-gray-700"
                    >
                        {{ ingredient }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <OnboardingModal :show="activeModal === 'onboarding'" @close="closeModal" />
</template>
