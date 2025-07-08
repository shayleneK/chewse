<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
</script>
<template>
    <div>
        <nav class="bg-creampink border-gray-200 px-2 sm:px-4 py-2.5 rounded">
            <div
                class="container flex flex-wrap justify-between items-center mx-auto"
            >
                <strong class="text-white">CHEWSE</strong>
                <div class="flex gap-10 text-darkchocolate">
                    <div v-if="$page.props.auth.user">
                        <Link
                            :href="route('auth.logout')"
                            method="post"
                            as="button"
                            type="button"
                            class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Sign out
                        </Link>
                    </div>
                    <div v-else class="flex gap-10">
                        <a href="/">Register</a>
                        <a href="/Login">Login</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>
