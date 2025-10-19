<script lang="ts" setup>
const tweets = [
    {
        id: 1,
        name: 'Hazel Brook',
        avatar: 'https://randomuser.me/api/portraits/women/44.jpg',
        time: '2h ago',
        content:
            'Just tried the new Gelato shop on Bleecker - Pistachio is a must! 😋🍦',
        hashtags: '#nycfoodie',
        liked: false,
        likes: 164,
    },
    {
        id: 2,
        name: 'Jamie F.',
        avatar: 'https://randomuser.me/api/portraits/men/48.jpg',
        time: '3h ago',
        content: 'Don’t miss the new exhibit at the Met! So inspiring! ✨',
        hashtags: '#artlover',
        liked: true,
        likes: 27,
    },
    {
        id: 3,
        name: 'Jamie F.',
        avatar: 'https://randomuser.me/api/portraits/men/48.jpg',
        time: '3h ago',
        content: 'Don’t miss the new exhibit at the Met! So inspiring! ✨',
        hashtags: '#artlover',
        liked: true,
        likes: 27,
    },
];
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
                            :alt="$page.props.auth.user.name"
                            class="h-full w-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 font-bold text-white"
                        ></div>
                    </div>
                    <Link
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

        <!-- main content test area -->

        <main class="mt-12 flex flex-grow justify-center">
            <div class="w-full max-w-[653px] space-y-6">
                <!-- Tweet Box -->
                <div class="rounded-xl bg-white p-5 shadow">
                    <div class="flex space-x-3">
                        <img
                            src="https://randomuser.me/api/portraits/men/32.jpg"
                            alt="User"
                            class="h-10 w-10 rounded-full"
                        />

                        <div class="flex-1">
                            <textarea
                                class="h-[104px] w-full max-w-[600px] resize-none rounded-[8px] border-none bg-gray-200 p-3 text-gray-700 placeholder-gray-400 focus:ring-0 focus:outline-none"
                                placeholder="What's happening?"
                                maxlength="280"
                            ></textarea>

                            <div
                                class="mt-2 flex items-center justify-between text-sm text-gray-400"
                            >
                                <span>20 characters remaining</span>
                                <button
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
                        <img
                            :src="tweet.avatar"
                            alt="User"
                            class="h-10 w-10 rounded-full"
                        />
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h2 class="font-semibold text-gray-800">
                                    {{ tweet.name }}
                                </h2>
                                <span class="text-sm text-gray-400">{{
                                    tweet.time
                                }}</span>
                            </div>

                            <p class="mt-1 text-gray-700">
                                {{ tweet.content }}
                                <span
                                    v-if="tweet.hashtags"
                                    class="text-blue-500"
                                >
                                    {{ tweet.hashtags }}
                                </span>
                            </p>

                            <div
                                class="mt-3 flex items-center space-x-1 text-gray-500"
                            >
                                <svg
                                    v-if="tweet.liked"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-red-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
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
                                <span>{{ tweet.likes }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
