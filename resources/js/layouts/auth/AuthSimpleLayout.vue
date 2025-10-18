<script setup lang="ts">
defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 bg-foreground p-6 md:p-10"
    >
        <div class="w-full max-w-sm">
            <div class="flex flex-col">
                <div class="flex flex-col items-center gap-4">
                    <div
                        class="mb-1 flex h-9 w-9 items-center justify-center rounded-md"
                    ></div>
                    <span class="sr-only">{{ title }}</span>

                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium">{{ title }}</h1>
                        <p class="text-center text-sm text-muted-foreground">
                            {{ description }}
                        </p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
