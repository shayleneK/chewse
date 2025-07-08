<template>
    <div
        v-show="show"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto"
    >
        <!-- Backdrop: No transition -->
        <div
            class="fixed inset-0 bg-black/50 backdrop-blur-none"
            @click="$emit('close')"
        />

        <!-- Modal Box with Transition -->
        <transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <!-- This wrapper ensures only the modal box is animated -->
            <div v-show="show" class="relative z-50 w-2/3 px-4">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <!-- Close Button -->
                    <button
                        type="button"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 focus:outline-none text-2xl"
                        @click="$emit('close')"
                    >
                        &times;
                    </button>

                    <!-- Slot for content -->
                    <slot />
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});
defineEmits(["close"]);
</script>
