
<template>
  <div>
    <!-- Floating Button -->
    <button @click="toggleChat" class="fixed bottom-4 right-4 bg-rose-500 text-white p-3 rounded-full shadow-lg z-50">
      💬
    </button>

    <!-- Chat Panel -->
    <div v-if="isOpen" class="fixed bottom-20 right-4 w-80 max-h-[80vh] bg-white rounded-xl shadow-xl border flex flex-col z-50">
      <div class="p-3 bg-rose-500 text-white font-bold flex justify-between items-center rounded-t-xl">
        <span>Cooking Assistant</span>
        <button @click="toggleChat">✖</button>
      </div>

      <div class="p-3 overflow-y-auto flex-1">
        <div v-for="(msg, i) in messages" :key="i" class="mb-2">
          <div :class="msg.sender === 'user' ? 'text-right' : 'text-left'">
            <span class="inline-block px-3 py-1 rounded-lg" :class="msg.sender === 'user' ? 'bg-rose-100' : 'bg-gray-100'">
              {{ msg.text }}
            </span>
          </div>
        </div>
      </div>

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
import { ref } from 'vue'
import axios from 'axios'

const isOpen = ref(false)
const userInput = ref('')
const messages = ref([])
const loading = ref(false)

function toggleChat() {
  isOpen.value = !isOpen.value
}

async function sendMessage() {
  const message = userInput.value.trim()
  if (!message) return

  // Add user message to chat
  messages.value.push({ text: message, sender: 'user' })
  userInput.value = ''
  loading.value = true

  try {
    const response = await axios.post('/chatbot', { message })
    const botText = response.data.response || 'Sorry, I couldn’t understand that.'
    messages.value.push({ text: botText, sender: 'bot' })
  } catch (error) {
    console.error('Chatbot error:', error)
    messages.value.push({ text: 'Something went wrong. Please try again.', sender: 'bot' })
  } finally {
    loading.value = false
  }
}
</script>
