<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <AuthBase
        class="text-black"
        title="Welcome to MiniTweet"
        description="Connect with friends in 20 characters or less"
    >
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Input
                        class="h-[50px] w-[400px] rounded-2xl border-0 bg-[#12141917] text-base transition duration-200 outline-none focus:ring-2 focus:ring-black"
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        class="h-[50px] w-[400px] rounded-2xl border-0 bg-[#12141917] text-base transition duration-200 outline-none focus:ring-2 focus:ring-black"
                        id="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <Button
                    type="submit"
                    class="h-[50px] w-[400px] rounded-2xl bg-black text-lg font-semibold text-white transition duration-200 hover:bg-gray-800 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                    :tabindex="4"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />
                    Log in
                </Button>
            </div>
            <div class="text-center text-sm text-muted-foreground">
                <Button
                    type="button"
                    @click="$inertia.visit(register())"
                    class="mt-[14px] h-[50px] w-[400px] rounded-2xl border-2 border-gray-300 text-lg font-semibold text-black transition duration-200 hover:border-gray-900 hover:bg-gray-800 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                    :tabindex="5"
                    data-test="register-button"
                >
                    Create Account
                </Button>
            </div>
        </Form>
    </AuthBase>
</template>
