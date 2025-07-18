<script setup>
import TextInput from "@/components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: null,
    password: null,
    password_confirmation: null,
});

const submit = () => {
    form.post(route("auth.register"), {
        onError: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <div class="m-auto flex h-full flex-col items-center justify-center mt-40">
        <div class="flex h-90 w-1/3 flex-col items-center rounded-lg bg-white">
            <h1 class="m-11 font-sans text-4xl font-bold text-chocolate">
                Register
            </h1>
            <form @submit.prevent="submit" class="flex w-70 flex-col gap-0.5">
                <TextInput
                    label="username"
                    name="name"
                    type="string"
                    v-model="form.name"
                    :message="form.errors.name"
                />
                <TextInput
                    label="password"
                    name="password"
                    type="password"
                    v-model="form.password"
                    :message="form.errors.password"
                />
                <TextInput
                    label="password_confirmation"
                    name="confirm password"
                    type="password"
                    v-model="form.password_confirmation"
                    :message="form.errors.password"
                />
                <button
                    class="w-full rounded-lg bg-pink-500 p-2 text-white transition-colors hover:bg-pink-200"
                    :disabled="form.processing"
                >
                    Register
                </button>
            </form>
        </div>
    </div>
</template>
