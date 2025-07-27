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
const page_index = ref(0);
let timer = null;

const form = useForm({
    message: "",
    history: [],
    context: "Recipe Feedback",
    recipe: null,
    step: 0,
});

onMounted(() => {
    console.log("📄 Recipe.vue mounted");
    selectedRecipe.value = props.recipe;
    recipeStep.value = 0;
    startInactivityTimer();
    form.clearErrors();
});

onBeforeUnmount(() => {
    clearTimeout(timer);
});

function startInactivityTimer() {
    clearTimeout(timer);
    console.log("⏱️ Timer started/restarted");
    timer = setTimeout(() => {
        console.log("👋 Emitting show-chatbot");
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

function submitFeedback() {
    form.history = history.value;
    form.recipe = selectedRecipe.value;
    form.step = recipeStep.value;

    form.post("/chatbot-feedback", {
        onStart: () => {
            loading.value = true;
        },
        onSuccess: (res) => {
            const reply = res.props.response || "Thanks for your feedback!";
            const replyHtml = marked.parse(reply);

            // Push bot reply
            messages.value.push({ text: replyHtml, sender: "bot" });

            // Update history & confidence
            history.value = res.props.history || history.value;
            confidence.value = res.props.confidence || confidence.value;

            alert("Feedback sent successfully!");
            form.reset("message");
        },
        onError: () => {
            alert("Something went wrong while submitting feedback.");
        },
        onFinish: () => {
            loading.value = false;
        },
    });
}
</script>

<template>
    <div
        class="flex flex-col p-6 max-w-6xl mx-auto bg-white rounded shadow-md mt-8"
    >
        <!-- Intro Page -->
        <div v-if="page_index === 0" class="flex flex-col md:flex-row gap-6">
            <img
                :src="props.recipe.image"
                alt="Recipe"
                class="w-full md:w-1/3 rounded"
            />
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">
                        {{ props.recipe.name }}
                    </h1>
                    <p class="text-gray-600 mb-2">
                        {{ props.recipe.description }}
                    </p>
                    <p class="text-gray-500 mb-4">
                        <strong>Time:</strong> {{ props.recipe.time }}
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

        <!-- Step Pages -->
        <div
            v-else-if="
                page_index > 0 && page_index <= props.recipe.steps.length
            "
            class="p-4 bg-white rounded-md shadow-md"
        >
            <h3 class="text-2xl font-bold mb-4">
                Step {{ page_index }} of {{ props.recipe.steps.length }}
            </h3>
            <p class="text-lg text-gray-700">
                {{ props.recipe.steps[page_index - 1] }}
            </p>
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
                <small
                    class="text-red-500 text-xs"
                    v-if="form.errors.message"
                    >{{ form.errors.message }}</small
                >
                <button
                    type="submit"
                    class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded"
                    :disabled="loading || form.processing"
                >
                    {{ loading ? "Submitting..." : "Submit Feedback" }}
                </button>
            </form>
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
