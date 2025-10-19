<script lang="ts" setup>
import HeartFilled from '@/components/icon/HeartFilled.vue';
import HeartOutline from '@/components/icon/HeartOutline.vue';
import Logout from '@/components/icon/Logout.vue';
import Sent from '@/components/icon/Sent.vue';
import { Link, usePage } from '@inertiajs/vue3';
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
const getUserInitials = (firstname: string) => {
    return firstname.charAt(0).toUpperCase();
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
                <div class="flex items-center gap-9">
                    <div
                        class="h-10 w-10 overflow-hidden rounded-full bg-gray-300"
                    >
                        <div
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 font-bold text-white"
                        >
                            {{
                                getUserInitials($page.props.auth.user.firstname)
                            }}
                            <!-- Fixed empty avatar -->
                        </div>
                    </div>
                    <Link
                        href="/logout"
                        method="post"
                        class="flex items-center gap-2 text-black hover:text-gray-700"
                    >
                        <Logout />
                        <span>Logout</span>
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
                                :alt="$page.props.auth.user.firstname"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 font-bold text-white"
                            >
                                {{
                                    getUserInitials(
                                        $page.props.auth.user.firstname,
                                    )
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
                                    class="flex h-[40px] w-[100px] items-center justify-center gap-2 rounded-[8px] bg-black px-2 py-1.5 text-white transition hover:bg-gray-800"
                                >
                                    <Sent />
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
                    <div class="flex flex-col space-x-3">
                        <!-- Fixed tweet user avatar -->
                        <div class="flex flex-row gap-3">
                            <div
                                class="flex h-10 w-10 overflow-hidden rounded-full bg-gray-300"
                            >
                                <img
                                    v-if="tweet.user.avatar_url"
                                    :src="tweet.user.avatar_url"
                                    :alt="tweet.user.firstname"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 font-bold text-white"
                                >
                                    {{ getUserInitials(tweet.user.firstname) }}
                                </div>
                            </div>
                            <div class="flex">
                                <div class="flex flex-col justify-between">
                                    <h2 class="font-semibold text-gray-800">
                                        {{ tweet.user.firstname }}&nbsp;{{
                                            tweet.user.surname
                                        }}
                                    </h2>
                                    <span class="text-sm text-gray-400">{{
                                        tweet.created_at
                                    }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="mt-1 text-gray-700">
                                {{ tweet.content }}
                            </p>
                        </div>
                        <div
                            class="mt-3 flex items-center space-x-1 text-gray-500"
                        >
                            <HeartFilled
                                v-if="tweet.liked_by_user"
                                @click="toggleLike(tweet)"
                                class="cursor-pointer"
                            />
                            <HeartOutline
                                v-else
                                @click="toggleLike(tweet)"
                                class="cursor-pointer"
                            />
                            <span>{{ tweet.likes_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
