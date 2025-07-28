<script setup>
import { ref, onMounted, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { selectedRecipe } from "@/composables/chatbotStore";
import OnboardingModal from "@/components/modals/OnboardingModal.vue";
import { useModal } from "@/composables/useModal";

const { recipes, selectedDifficulty, popupMessage, redirectRecipeId } = defineProps({
    recipes: Array,
    selectedDifficulty: String,
    popupMessage: String,
    redirectRecipeId: Number,
});

const showPopup = ref(false);
const message = ref("")
const difficulty = ref(selectedDifficulty || "All");

const { activeModal, showModal, closeModal } = useModal();
const user = usePage().props.auth.user;

onMounted(() => {
    if (user.has_onboarded === false) {
        showModal("onboarding");
    }

    console.log("popupMessage:", popupMessage);
    console.log("redirectRecipeId: ", redirectRecipeId);

    if (popupMessage) {
        message.value = popupMessage;
        showPopup.value = true;
    }
});

watch(difficulty, (newVal) => {
    const query = newVal === "All" ? {} : { difficulty: newVal };
    router.get("/Home", query, {
        preserveState: true,
        preserveScroll: true,
    });
});

function startRecipe(id) {
    const selected = recipes.find(r => r.id === id);
    if (selected) {
        selectedRecipe.value = selected;
    }
    router.visit(`/Recipe/${id}/show`);
}

function goToRedirectRecipe() {
    if (redirectRecipeId) {
        router.visit(`/Recipe/${redirectRecipeId}/show`);
    }
}
</script>

<template>
    <div class="flex flex-col p-5 items-center">
        <h1 class="font-bold mb-4 text-pink-500 text-4xl">Recipes</h1>

    

        <div class="mb-6 flex gap-4 items-center">
        <label class="text-lg font-medium text-gray-700">Filter by Difficulty:</label>
        <select v-model="difficulty" class="border rounded px-3 py-1">
            <option value="All">All</option>
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
        </select>
        </div>

        <!-- 💬 Popup -->
        <div
        v-if="showPopup"
        class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 w-3/4 rounded shadow"
        >
        <div class="flex justify-between items-center">
            <p>{{ message }}</p>
            <div class = "flex ml-auto gap-2">
                <button
            v-if="message.includes('harder') || message.includes('easier')"
            @click="goToRedirectRecipe"
            class="ml-4 bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm"
            >
            Let's Do It!
            </button>
            <button @click="showPopup = false" class="text-sm text-yellow-600 hover:underline">Dismiss</button>
            </div>
            
        </div>
        </div>

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
