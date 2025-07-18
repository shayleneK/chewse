<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
</script>
<template>
    <div>
        <nav
            class="bg-pink-500 text-pink-100 border-gray-200 px-2 sm:px-4 py-2.5 rounded-b-md"
        >
            <div class="container flex justify-between items-center mx-auto">
                <strong class="text-pink-100 font-bold">CHEWSE</strong>
                <div class="flex gap-10 text-pink-100 w-full justify-center">
                    <div class="flex ml-auto" v-if="$page.props.auth.user">
                        <a
                            href="/Home"
                            class="block px-4 font-medium py-2 text-left text-sm text-pink-200 hover:bg-gray-100 hover:text-pink-400 rounded"
                            >Home</a
                        >

                        <Link
                            :href="route('auth.logout')"
                            method="post"
                            as="button"
                            type="button"
                            class="block px-4 font-medium py-2 text-left text-sm text-pink-200 hover:bg-gray-100 hover:text-pink-400 rounded"
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
