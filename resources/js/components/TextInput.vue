<script setup>
const model = defineModel({
    type: null,
    required: true,
});

defineProps({
    label: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "text",
    },
    message: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div class="mb-3">
        <input
            :type="type"
            :id="name"
            :name="name"
            :placeholder="name"
            v-model="model"
            class="border-b border-gray-900 p-2 w-full focus:bg-white"
        />
        <!-- <input :type="type" :id="name" :name="name" :placeholder="name" v-model="model" class=" bg-gray-100 rounded-lg p-2 pl-4 w-full" /> -->

        <small v-if="message" class="text-red-500 text-xs">{{ message }}</small>
    </div>
</template>
