<script setup>
import { Head, router } from "@inertiajs/vue3";
import axios from "axios";
import { ref, onMounted } from "vue";
import { selectedRecipe, recipeStep } from "@/composables/chatbotStore"; // ← import global store

const props = defineProps({
    recipe: Object,
});

const page_index = ref(0);

// Assign the selected recipe globally when this page loads
onMounted(() => {
    selectedRecipe.value = props.recipe;
});

function previousPage() {
    page_index.value--;
    recipeStep.value--;
}
function nextPage() {
    page_index.value++;
    if (page_index.value > 0) recipeStep.value++;
}
</script>

<template>
    <div class="flex flex-col p-4">
        <!-- Page 0: Overview -->
        <div v-if="page_index === 0" class="flex p-2 gap-4">
            <img
                :src="props.recipe.image"
                alt=""
                class="w-1/4 h-auto rounded mt-2 mb-4"
            />
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold mb-4">{{ props.recipe.name }}</h1>
                <p class="text-gray-600">{{ props.recipe.description }}</p>
                <p class="text-gray-600">{{ props.recipe.time }}</p>
                <div>
                    <h3 class="font-semibold mt-4 mb-2">Ingredients:</h3>
                    <ol class="list-decimal list-inside space-y-1">
                        <li
                            v-for="(ingredient, index) in recipe.ingredients"
                            :key="index"
                        >
                            {{ ingredient }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Steps -->
        <div
            v-else-if="page_index > 0 && page_index <= recipe.steps.length"
            class="p-2 bg-white rounded-md shadow-md"
        >
            <h3 class="font-semibold mb-2">Step {{ page_index }}:</h3>
            <p class="text-lg">{{ recipe.steps[page_index - 1] }}</p>
        </div>

        <!-- End message -->
        <div v-else class="p-2">
            <h3 class="text-xl font-bold">You're done!</h3>
            <p class="text-gray-600">How was your experience?</p>
            <input class="bg-white" type="text" />
        </div>

        <!-- Navigation Button -->
        <div class="flex mt-4 gap-4">
            <button
                @click="previousPage"
                class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-300"
            >
                Back
            </button>
            <button
                @click="nextPage"
                class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-300"
            >
                Next
            </button>
        </div>
    </div>
</template>
