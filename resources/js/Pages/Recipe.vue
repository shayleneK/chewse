<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { selectedRecipe, recipeStep } from "@/composables/chatbotStore";

const props = defineProps({
  recipe: Object,
});

const page_index = ref(0);
let timer = null;

onMounted(() => {
  console.log("📄 Recipe.vue mounted");
  selectedRecipe.value = props.recipe;
  recipeStep.value = 0;
  startInactivityTimer();
});

onBeforeUnmount(() => {
  clearTimeout(timer);
});

function startInactivityTimer() {
  clearTimeout(timer);
  console.log("⏱️ Timer started/restarted"); // ✅ Log when timer starts
  timer = setTimeout(() => {
    console.log("👋 Emitting show-chatbot"); // ✅ Log when event is emitted
    window.dispatchEvent(new CustomEvent("show-chatbot"));
  }, 10000);
}

function previousPage() {
  if (page_index.value > 0) {
    page_index.value--;
    recipeStep.value = page_index.value - 1;
    startInactivityTimer();
  }
}

function nextPage() {
  if (page_index.value <= props.recipe.steps.length) {
    page_index.value++;
    recipeStep.value = page_index.value - 1;
    startInactivityTimer();
  }
}
</script>

<template>
  <div class="flex flex-col p-6 max-w-6xl mx-auto bg-white rounded shadow-md mt-8">
    <!-- Landscape Layout -->
    <div v-if="page_index === 0" class="flex flex-col md:flex-row gap-6">
      <img :src="props.recipe.image" alt="Recipe" class="w-full md:w-1/3 rounded" />
      <div class="flex flex-col justify-between">
        <div>
          <h1 class="text-3xl font-bold mb-2">{{ props.recipe.name }}</h1>
          <p class="text-gray-600 mb-2">{{ props.recipe.description }}</p>
          <p class="text-gray-500 mb-4"><strong>Time:</strong> {{ props.recipe.time }}</p>

          <h2 class="text-xl font-semibold mb-2">Ingredients</h2>
          <ul class="list-disc list-inside space-y-1">
            <li v-for="(ingredient, index) in props.recipe.ingredients" :key="index">
              {{ ingredient }}
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div
      v-else-if="page_index > 0 && page_index <= props.recipe.steps.length"
      class="p-4 bg-white rounded-md shadow-md"
    >
      <h3 class="text-2xl font-bold mb-4">Step {{ page_index }} of {{ props.recipe.steps.length }}</h3>
      <p class="text-lg text-gray-700">{{ props.recipe.steps[page_index - 1] }}</p>
    </div>

    <div v-else class="p-4 bg-white rounded-md shadow-md">
      <h3 class="text-2xl font-bold text-pink-600 mb-2">You're done!</h3>
      <p class="text-gray-700 mb-4">How was your experience?</p>
      <textarea
        placeholder="Leave your feedback here..."
        class="w-full border border-gray-300 rounded p-2 mb-4"
      ></textarea>
      <button
        class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded"
      >
        Submit Feedback
      </button>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between mt-6">
      <button
        @click="previousPage"
        :disabled="page_index === 0"
        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded disabled:opacity-50"
      >
        Back
      </button>

      <button
        v-if="page_index < props.recipe.steps.length + 1"
        @click="nextPage"
        class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded"
      >
        Next
      </button>
    </div>
  </div>
</template>
