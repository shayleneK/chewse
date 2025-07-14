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
    <div>
        <h1 class="text-2xl font-bold mb-4">Recipes</h1>

        <div
            v-for="recipe in recipes"
            :key="recipe.id"
            class="mb-8 p-4 border rounded-lg shadow"
        >
            <div class="flex">
                <h2 class="text-xl font-semibold">{{ recipe.name }}</h2>
                <button
                    class="ml-auto px-4 py-2 bg-blue-500 text-white rounded"
                    @click="startRecipe(recipe.id)"
                >
                    Start Recipe
                </button>
            </div>
            <img
                :src="recipe.image"
                alt=""
                class="w-1/3 h-auto rounded mt-2 mb-4"
            />
            <p class="mb-2 text-gray-600">{{ recipe.description }}</p>

            <h3 class="font-semibold mt-4 mb-2">Steps:</h3>
            <ol class="list-decimal list-inside space-y-1">
                <li v-for="(step, index) in recipe.steps" :key="index">
                    {{ step }}
                </li>
            </ol>
        </div>
    </div>
    <OnboardingModal :show="activeModal === 'onboarding'" @close="closeModal" />
</template>
