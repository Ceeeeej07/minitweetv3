<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3'; // Added Link import
import axios from 'axios';
import { ref } from 'vue';

const page = usePage();
const tweets = ref(page.props.tweets || []);
const content = ref('');
const maxChars = 280;

// Post new tweet
const postTweet = async () => {
    if (!content.value.trim()) return;

    try {
        const response = await axios.post('/tweets', {
            content: content.value,
        });
        tweets.value.unshift(response.data);
        content.value = '';
    } catch (error) {
        console.error('Tweet failed:', error);
    }
};

const toggleLike = async (tweet: any) => {
    try {
        if (tweet.liked_by_user) {
            const response = await axios.delete(`/tweets/${tweet.id}/like`); // Fixed URL
            tweet.liked_by_user = response.data.liked_by_user;
            tweet.likes_count = response.data.likes_count;
        } else {
            const response = await axios.post(`/tweets/${tweet.id}/like`);
            tweet.liked_by_user = response.data.liked_by_user;
            tweet.likes_count = response.data.likes_count;
        }
    } catch (error) {
        console.error('Error toggling like:', error);
    }
};

// Added function for user initials
const getUserInitials = (email: string) => {
    return email.charAt(0).toUpperCase();
};
</script>

<template>
    <div class="min-h-screen bg-white text-black">
        <!-- Header -->
        <div
            class="sticky top-0 z-10 border-b border-gray-200 bg-white/80 backdrop-blur"
        >
            <div
                class="container mx-auto flex max-w-full items-center justify-between px-12 py-4"
            >
                <h1 class="text-2xl font-bold">MiniTweet</h1>
                <div class="flex items-center gap-6">
                    <div
                        class="h-10 w-10 overflow-hidden rounded-full bg-gray-300"
                    >
                        <img
                            v-if="$page.props.auth.user.avatar_url"
                            :src="$page.props.auth.user.avatar_url"
                            :alt="$page.props.auth.user.email"
                            class="h-full w-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 font-bold text-white"
                        >
                            {{ getUserInitials($page.props.auth.user.email) }}
                            <!-- Fixed empty avatar -->
                        </div>
                    </div>
                    <Link
                        href="/logout"
                        method="post"
                        class="flex items-center gap-2 text-gray-700 hover:text-gray-900"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            ></path>
                        </svg>
                        <span>logout</span>
                    </Link>
                </div>
            </div>
        </div>

        <main class="mt-12 flex flex-grow justify-center">
            <div class="w-full max-w-[653px] space-y-6">
                <!-- Tweet Box -->
                <div class="rounded-xl bg-white p-5 shadow">
                    <div class="flex space-x-3">
                        <!-- Fixed user avatar -->
                        <div
                            class="h-10 w-10 overflow-hidden rounded-full bg-gray-300"
                        >
                            <img
                                v-if="$page.props.auth.user.avatar_url"
                                :src="$page.props.auth.user.avatar_url"
                                :alt="$page.props.auth.user.email"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 font-bold text-white"
                            >
                                {{
                                    getUserInitials($page.props.auth.user.email)
                                }}
                            </div>
                        </div>

                        <div class="flex-1">
                            <textarea
                                v-model="content"
                                class="h-[104px] w-full max-w-[600px] resize-none rounded-[8px] border-none bg-gray-200 p-3 text-gray-700 placeholder-gray-400 focus:ring-0 focus:outline-none"
                                placeholder="What's happening?"
                                maxlength="280"
                            ></textarea>
                            <div
                                class="mt-2 flex items-center justify-between text-sm text-gray-400"
                            >
                                <span
                                    >{{ maxChars - content.length }} characters
                                    remaining</span
                                >
                                <button
                                    @click="postTweet"
                                    class="rounded-lg bg-black px-4 py-1.5 text-white transition hover:bg-gray-800"
                                >
                                    Tweet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tweets -->
                <div
                    v-for="tweet in tweets"
                    :key="tweet.id"
                    class="rounded-xl bg-white p-5 shadow"
                >
                    <div class="flex space-x-3">
                        <!-- Fixed tweet user avatar -->
                        <div
                            class="h-10 w-10 overflow-hidden rounded-full bg-gray-300"
                        >
                            <img
                                v-if="tweet.user.avatar_url"
                                :src="tweet.user.avatar_url"
                                :alt="tweet.user.email"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 font-bold text-white"
                            >
                                {{ getUserInitials(tweet.user.email) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h2 class="font-semibold text-gray-800">
                                    {{ tweet.user.email }}
                                </h2>
                                <span class="text-sm text-gray-400">{{
                                    tweet.created_at
                                }}</span>
                            </div>
                            <p class="mt-1 text-gray-700">
                                {{ tweet.content }}
                            </p>
                            <div
                                class="mt-3 flex items-center space-x-1 text-gray-500"
                            >
                                <svg
                                    v-if="tweet.liked_by_user"
                                    @click="toggleLike(tweet)"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 cursor-pointer text-red-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    @click="toggleLike(tweet)"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 cursor-pointer hover:text-red-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.015-4.5-4.5-4.5-1.59 0-2.986.832-3.75 2.086A4.125 4.125 0 009 3.75C6.515 3.75 4.5 5.765 4.5 8.25c0 7.22 7.5 11.25 7.5 11.25s7.5-4.03 7.5-11.25z"
                                    />
                                </svg>
                                <span>{{ tweet.likes_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
