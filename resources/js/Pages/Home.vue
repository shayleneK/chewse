<script setup>
import { useModal } from "@/composables/useModal";
import { usePage } from "@inertiajs/vue3";

import OnboardingModal from "@/components/modals/OnboardingModal.vue";
const { activeModal, showModal, closeModal } = useModal();
import { ref, onMounted } from "vue";

const showOnboardingModal = ref(false);
const user = usePage().props.auth.user;

onMounted(() => {
    /* if (user.has_onboarded === false) {
        showModal("onboarding");
    } */
});
</script>
<template>
    <div>
        <h1>Home</h1>
    </div>
    <!-- <OnboardingModal :show="activeModal === 'onboarding'" @close="closeModal" /> -->
</template>
