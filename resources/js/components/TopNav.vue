<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import chewseLogo from "./chewse_logo.svg";

const page = usePage();
const user = page.props.auth.user;
const dropdownOpen = ref(false);

// Compute confidence level badge
const confidence = user?.level_value ?? 50;
const confidenceLabel =
    confidence <= 33 ? "Beginner" : confidence <= 66 ? "Advanced" : "Master";
const confidenceColor =
    confidence <= 33
        ? "bg-red-500"
        : confidence <= 66
        ? "bg-yellow-500"
        : "bg-green-500";

console.log("User:", user);
</script>

<template>
    <div>
        <nav
            class="bg-pink-500 text-pink-100 border-gray-200 px-2 sm:px-4 py-2.5 rounded-b-md"
        >
            <div class="container flex justify-between items-center mx-auto">
                <!-- Logo & Title -->
                <div class="flex items-center gap-2">
                    <img :src="chewseLogo" alt="Logo" class="invert h-10" />
                    <strong class="text-pink-100 font-bold">CHEWSE</strong>
                </div>

                <!-- Navigation Links -->
                <div class="flex gap-6 items-center">
                    <!-- Confidence Badge -->
                    <div v-if="user" class="flex items-center">
                        <span
                            :class="[
                                'px-3 py-1 rounded-full text-xs font-semibold text-white',
                                confidenceColor,
                            ]"
                        >
                            {{ confidenceLabel }}
                        </span>
                    </div>

                    <!-- User Dropdown -->
                    <div v-if="user" class="relative">
                        <button
                            @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center px-4 py-2 text-sm font-medium text-pink-200 hover:bg-gray-100 hover:text-pink-400 rounded"
                        >
                            {{ user.name }}
                            <svg
                                class="w-4 h-4 ml-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>
                        <div
                            v-if="dropdownOpen"
                            class="absolute right-0 mt-2 w-40 bg-white text-gray-700 rounded shadow-lg z-10"
                        >
                            <Link
                                :href="route('auth.logout')"
                                method="post"
                                as="button"
                                type="button"
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                            >
                                Sign out
                            </Link>
                        </div>
                    </div>

                    <!-- Guest Links -->
                    <div v-else class="flex gap-4">
                        <a href="/" class="hover:underline">Register</a>
                        <a href="/Login" class="hover:underline">Login</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
