<template>
    <div v-if="!isHomepage">
        <!-- Floating Button -->
        <button
            @click="toggleChat"
            class="fixed bottom-4 right-4 bg-pink-500 text-white p-3 rounded-full shadow-lg z-50"
        >
            💬
        </button>

        <!-- Chat Panel -->
        <div
            v-if="isOpen"
            class="fixed bottom-20 right-4 w-80 max-h-[80vh] bg-white rounded-xl shadow-xl border flex flex-col z-50"
        >
            <div
                class="p-3 bg-pink-500 text-white font-bold flex justify-between items-center rounded-t-xl"
            >
                <span>Cooking Assistant</span>
                <button @click="toggleChat">✖</button>
            </div>

            <!-- Chat Content -->
            <div ref="chatScroll" class="p-3 overflow-y-auto flex-1">
                <div v-for="(msg, i) in messages" :key="i" class="mb-2">
                    <div
                        :class="
                            msg.sender === 'user' ? 'text-right' : 'text-left'
                        "
                    >
                        <span
                            class="inline-block px-3 py-2 rounded-lg max-w-[70%] break-words"
                            :class="
                                msg.sender === 'user'
                                    ? 'bg-rose-100 text-black'
                                    : 'bg-gray-100 text-black'
                            "
                            v-html="msg.text"
                        ></span>
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="p-3 border-t">
                <input
                    v-model="userInput"
                    @keydown.enter="sendMessage"
                    type="text"
                    placeholder="Ask something..."
                    class="w-full border rounded p-2"
                    :disabled="loading"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { selectedRecipe } from "@/composables/chatbotStore";

import { ref, watch, nextTick, computed } from "vue";
import axios from "axios";
import { marked } from "marked";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const isHomepage = computed(() => {
    return page.url.toLowerCase().startsWith("/home");
})

const props = defineProps({
    recipe: Object
});

console.log("Chatbot received recipe prop:", props.recipe); 


const isOpen = ref(false);
const userInput = ref("");
const messages = ref([]);
const loading = ref(false);
const chatScroll = ref(null);
const recipe = selectedRecipe;


// Initial state
const history = ref([]);
const confidence = ref("low"); // You can pass this from server/user profile

function toggleChat() {
    isOpen.value = !isOpen.value;
    if (isOpen.value) scrollToBottom();
}

async function sendMessage() {
    const message = userInput.value.trim();
    if (!message) return;

    // Push user message
    messages.value.push({ text: message, sender: "user" });
    history.value.push({ role: "user", parts: [{ text: message }] });
    userInput.value = "";
    loading.value = true;

    try {
    const res = await axios.post("/chatbot", {
        message,
        history: history.value,
        confidence: confidence.value,
        recipe: selectedRecipe.value,
    });

    const reply = res.data.response || "Sorry, I couldn’t understand that.";
    const replyHtml = marked.parse(reply);
    messages.value.push({ text: replyHtml, sender: "bot" });

    // Update history and confidence
    history.value = res.data.history || history.value;
    confidence.value = res.data.confidence || confidence.value;

    
    console.log("Server confidence:", res.data.confidence);
    console.log("Frontend confidence state:", confidence.value);

    } catch (err) {
        console.error("Chatbot error:", err);
        messages.value.push({
            text: "Something went wrong. Please try again.",
            sender: "bot",
        });
    } finally {
        loading.value = false;
        scrollToBottom();
    }

}

// Scroll to bottom when messages change
function scrollToBottom() {
    nextTick(() => {
        if (chatScroll.value) {
            chatScroll.value.scrollTop = chatScroll.value.scrollHeight;
        }
    });
}

watch(messages, scrollToBottom);
</script>
