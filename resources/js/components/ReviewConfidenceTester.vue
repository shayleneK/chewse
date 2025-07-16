<template>
    <div>
        <!-- Floating Button (bottom left) -->
        <button
            @click="togglePanel"
            class="fixed bottom-4 left-4 bg-blue-500 text-white p-3 rounded-full shadow-lg z-50"
        >
            📝
        </button>

        <!-- Review Confidence Chat Panel -->
        <div
            v-if="isOpen"
            class="fixed bottom-20 left-4 w-80 max-h-[60vh] bg-white rounded-xl shadow-xl border flex flex-col z-50"
        >
            <div class="p-3 bg-blue-500 text-white font-bold flex justify-between items-center rounded-t-xl">
                <span>Review Confidence Tester</span>
                <button @click="togglePanel">✖</button>
            </div>
            <div class="p-3 flex-1 flex flex-col overflow-y-auto" style="min-height:200px;max-height:40vh;">
                <div v-for="(msg, i) in messages" :key="i" class="mb-2">
                    <div v-if="msg.sender === 'user'" class="text-right">
                        <span class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-lg">{{ msg.text }}</span>
                    </div>
                    <div v-else class="text-left">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-lg">
                            Confidence: <span class="capitalize">{{ msg.text }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <form @submit.prevent="submitReview" class="p-3 flex gap-2 border-t">
                <textarea
                    v-model="review"
                    placeholder="Type your review here..."
                    class="w-full border rounded p-2"
                    rows="2"
                    @keydown.enter.exact.prevent="submitReview"
                ></textarea>
            </form>
            <div v-if="error" class="px-3 pb-3 text-red-500">{{ error }}</div>
        </div>
    </div>
</template>

<script setup>
import { ref, nextTick } from "vue";
import axios from "axios";

const isOpen = ref(false);
const review = ref("");
const messages = ref([]);
const error = ref("");
const loading = ref(false);

function togglePanel() {
    isOpen.value = !isOpen.value;
    review.value = "";
    error.value = "";
    if (!isOpen.value) {
        messages.value = [];
    }
}

async function submitReview() {
    if (!review.value.trim()) return;
    error.value = "";
    loading.value = true;
    // Add user message
    messages.value.push({ sender: "user", text: review.value });
    const currentReview = review.value;
    review.value = "";
    try {
        const res = await axios.post("/confidence", { review: currentReview });
        let confidence = (res.data.confidence || "").toLowerCase();
        if (!["low", "neutral", "high"].includes(confidence)) {
            confidence = "neutral";
        }
        messages.value.push({ sender: "bot", text: confidence });
        await nextTick();
        scrollToBottom();
    } catch (e) {
        error.value = e.response?.data?.error || "Something went wrong.";
    } finally {
        loading.value = false;
    }
}

function scrollToBottom() {
    setTimeout(() => {
        const panel = document.querySelector('.fixed.bottom-20.left-4 .flex-1');
        if (panel) panel.scrollTop = panel.scrollHeight;
    }, 100);
}
</script>