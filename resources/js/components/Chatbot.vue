<script setup>
import { selectedRecipe } from "@/composables/chatbotStore";
import { recipeStep } from "../composables/chatbotStore";
import { ref, watch, nextTick, computed, onMounted } from "vue";
import axios from "axios";
import { marked } from "marked";
import { usePage } from "@inertiajs/vue3";
import chewseLogo from "./chewse_logo_mascot.svg";

const page = usePage();
const isHomepage = computed(() => page.url.toLowerCase().startsWith("/home"));
const props = defineProps({ recipe: Object, show: Boolean });

const isOpen = ref(false);
const userInput = ref("");
const messages = ref([]);
const loading = ref(false);
const chatScroll = ref(null);
const recipe = selectedRecipe;
const history = ref([]);
const confidence = ref(null); // Only reflects what backend sends
const showBubble = ref(false);

function toggleChat() {
    isOpen.value = !isOpen.value;
    if (isOpen.value) scrollToBottom();
}

const isFirstOpen = ref(true);

watch(isOpen, (visible) => {
    if (visible && isFirstOpen.value) {
        messages.value.push({
            text: "Hi! I'm Chewsey, please let me know if you need help :3",
            sender: "bot",
        });
        isFirstOpen.value = false;
    }
});

onMounted(() => {
    window.addEventListener("show-chatbot", () => {
        showBubble.value = true;
    });
});

const isTyping = ref(false);

async function sendMessage() {
    const message = userInput.value.trim();
    if (!message) return;

    messages.value.push({ text: message, sender: "user" });
    history.value.push({ role: "user", parts: [{ text: message }] });
    userInput.value = "";
    loading.value = true;
    isTyping.value = true; // show typing indicator

    try {
        const res = await axios.post("/chatbot", {
            message,
            history: history.value,
            recipe: selectedRecipe.value,
            step: recipeStep.value,
        });

        const replyHtml = marked.parse(
            res.data.response || "Sorry, I couldn’t understand that."
        );
        messages.value.push({ text: replyHtml, sender: "bot" });

        history.value = res.data.history || history.value;
        confidence.value = res.data.confidence || confidence.value;
    } catch (err) {
        console.error("Chatbot error:", err);
        messages.value.push({
            text: "Something went wrong. Please try again.",
            sender: "bot",
        });
    } finally {
        loading.value = false;
        isTyping.value = false; // hide typing indicator
        scrollToBottom();
    }
}

function scrollToBottom() {
    nextTick(() => {
        if (chatScroll.value) {
            chatScroll.value.scrollTop = chatScroll.value.scrollHeight;
        }
    });
}

watch(messages, scrollToBottom);
watch(recipeStep, () => {
    showBubble.value = false;
});
</script>

<template>
    <div v-if="!isHomepage">
        <!-- Friendly Floating Bubble Message -->
        <transition name="fade">
            <div
                v-if="showBubble && !isOpen"
                class="fixed bottom-24 right-6 bg-white text-gr ay-800 px-4 py-2 rounded-xl shadow-lg text-sm z-50 max-w-xs"
            >
                <span class="italic">Need help? I'm here if you need me!</span>
                <div
                    class="absolute bottom-[-6px] right-6 w-3 h-3 bg-white transform rotate-45 shadow-md"
                ></div>
            </div>
        </transition>

        <!-- Floating Button -->
        <button
            @click="toggleChat"
            class="fixed bottom-4 right-4 bg-pink-500 text-white p-3 rounded-full shadow-lg z-50"
        >
            <img :src="chewseLogo" alt="Logo" class="h-6" />
        </button>

        <!-- Chat Panel -->
        <div
            v-if="isOpen"
            class="fixed bottom-20 right-4 max-h-[80vh] max-w-[40vh] bg-white rounded-xl shadow-xl border flex flex-col z-50"
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
                            class="inline-block px-3 py-2 rounded-lg break-words"
                            :class="
                                msg.sender === 'user'
                                    ? 'bg-rose-100 text-black'
                                    : 'bg-gray-100 text-black'
                            "
                            v-html="msg.text"
                        ></span>
                    </div>
                </div>
                <!-- Typing Indicator -->
                <div v-if="isTyping" class="mb-2 text-left">
                    <span
                        class="inline-block px-3 py-2 rounded-lg bg-gray-200 text-gray-600"
                    >
                        <span class="flex gap-1">
                            <span
                                class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"
                            ></span>
                            <span
                                class="w-2 h-2 bg-gray-500 rounded-full animate-bounce delay-150"
                            ></span>
                            <span
                                class="w-2 h-2 bg-gray-500 rounded-full animate-bounce delay-300"
                            ></span>
                        </span>
                    </span>
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
