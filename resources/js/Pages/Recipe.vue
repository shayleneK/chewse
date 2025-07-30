<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { useForm } from "@inertiajs/vue3";
import { selectedRecipe, recipeStep } from "@/composables/chatbotStore";
import { marked } from "marked";

const props = defineProps({
    recipe: Object,
});

const loading = ref(false);
const messages = ref([]);
const history = ref([]);
const confidence = ref(null);
const showFeedback = ref(false); // <-- controls feedback visibility
let timer = null;

const form = useForm({
    message: "",
    history: [],
    context: "Recipe Feedback",
    recipe: null,
    step: 0,
});

onMounted(() => {
    selectedRecipe.value = props.recipe;
    recipeStep.value = 0;
    startInactivityTimer();
    form.clearErrors();
    console.log("📄 Recipe.vue mounted");
});

onBeforeUnmount(() => {
    clearTimeout(timer);
});

function startInactivityTimer() {
    clearTimeout(timer);
    timer = setTimeout(() => {
        window.dispatchEvent(new CustomEvent("show-chatbot"));
    }, 10000);
}

function previousStep() {
    if (recipeStep.value > 0) {
        recipeStep.value--;
        startInactivityTimer();
    }
}

function nextStep() {
    if (recipeStep.value < props.recipe.steps.length - 1) {
        recipeStep.value++;
        startInactivityTimer();
    } else {
        showFeedback.value = true; // Show feedback form when done
    }
}

function submitFeedback() {
    form.history = history.value;
    form.recipe = selectedRecipe.value;
    form.step = recipeStep.value;

    form.post("/chatbot-feedback", {
        onStart: () => (loading.value = true),
        onSuccess: (res) => {
            const reply = res.props.response || "Thanks for your feedback!";
            const replyHtml = marked.parse(reply);
            messages.value.push({ text: replyHtml, sender: "bot" });
            history.value = res.props.history || history.value;
            confidence.value = res.props.confidence || confidence.value;
            alert("Feedback sent successfully!");
            form.reset("message");
        },
        onError: () => alert("Something went wrong while submitting feedback."),
        onFinish: () => (loading.value = false),
    });
}
</script>

<template>
    <div
        class="flex flex-col p-6 max-w-6xl mx-auto bg-white rounded shadow-md mt-8"
    >
        <!-- Intro + Steps (only if not on feedback) -->
        <div v-if="!showFeedback">
            <!-- Intro Section -->
            <div class="flex flex-col md:flex-row gap-6 mb-6">
                <img
                    :src="props.recipe.image"
                    alt="Recipe"
                    class="w-full md:w-1/3 rounded shadow"
                />
                <div class="flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">
                            {{ props.recipe.name }}
                        </h1>
                        <p class="text-gray-600 mb-2">
                            {{ props.recipe.description }}
                        </p>
                        <h2 class="text-xl font-semibold mb-2">Ingredients</h2>
                        <ul class="list-disc list-inside space-y-1">
                            <li
                                v-for="(ingredient, index) in props.recipe
                                    .ingredients"
                                :key="index"
                            >
                                {{ ingredient }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Steps Section -->
            <div class="p-4 pb-32 bg-white rounded-md shadow-md">
                <h3 class="text-2xl font-bold mb-4">Recipe Steps</h3>
                <div class="space-y-4">
                    <div
                        v-for="(step, index) in props.recipe.steps"
                        :key="index"
                        :class="[
                            'p-3 rounded border transition-all',
                            recipeStep === index
                                ? 'border-pink-500 bg-pink-50 shadow-md'
                                : 'border-gray-300 bg-gray-100 opacity-75',
                        ]"
                    >
                        <h4 class="font-semibold">Step {{ index + 1 }}</h4>
                        <p class="text-gray-700">{{ step }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback Page -->
        <div v-else class="p-4 bg-white rounded-md shadow-md">
            <h3 class="text-2xl font-bold text-pink-600 mb-2">You're done!</h3>
            <p class="text-gray-700 mb-4">How was your experience?</p>
            <form @submit.prevent="submitFeedback" class="space-y-4">
                <textarea
                    v-model="form.message"
                    placeholder="Leave your feedback here..."
                    class="w-full border border-gray-300 rounded p-2 mb-2"
                ></textarea>
                <small class="text-red-500 text-xs" v-if="form.errors.message">
                    {{ form.errors.message }}
                </small>
                <button
                    type="submit"
                    class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded"
                    :disabled="loading || form.processing"
                >
                    {{ loading ? "Submitting..." : "Submit Feedback" }}
                </button>
            </form>
        </div>

        <!-- Sticky Navigation -->
        <div
            v-if="!showFeedback"
            class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-300 flex justify-between px-6 py-4 shadow-md"
        >
            <button
                @click="previousStep"
                :disabled="recipeStep === 0"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded disabled:opacity-50"
            >
                Back
            </button>

            <button
                @click="nextStep"
                class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 mr-15 rounded"
            >
                {{
                    recipeStep === props.recipe.steps.length - 1
                        ? "Finish"
                        : "Next"
                }}
            </button>
        </div>
    </div>
</template>
