<script setup lang="ts">
import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <AuthBase class="text-black" title="Sign Up with Email">
        <Head title="Register" />

        <Form
            v-bind="RegisteredUserController.store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col"
        >
            <div class="grid gap-[14px]">
                <div class="flex flex-row gap-4">
                    <Input
                        class="mt-[32px] h-[50px] w-[192px] rounded-2xl border-0 bg-[#12141917] text-base transition duration-200 outline-none focus:ring-2 focus:ring-black"
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="firstname"
                        name="firstname"
                        placeholder="First name"
                    />
                    <InputError :message="errors.firstname" />
                    <Input
                        class="mt-[32px] h-[50px] w-[192px] rounded-2xl border-0 bg-[#12141917] text-base transition duration-200 outline-none focus:ring-2 focus:ring-black"
                        id="surname"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="surname"
                        name="surname"
                        placeholder="Surname"
                    />
                    <InputError :message="errors.surname" />
                </div>

                <div class="grid gap-2">
                    <Input
                        class="h-[50px] w-[400px] rounded-2xl border-0 bg-[#12141917] text-base transition duration-200 outline-none focus:ring-2 focus:ring-black"
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Input
                        class="h-[50px] w-[400px] rounded-2xl border-0 bg-[#12141917] text-base transition duration-200 outline-none focus:ring-2 focus:ring-black"
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Input
                        class="h-[50px] w-[400px] rounded-2xl border-0 bg-[#12141917] text-base transition duration-200 outline-none focus:ring-2 focus:ring-black"
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>
            </div>

            <Button
                class="mt-[42px] h-[50px] w-[400px] rounded-2xl bg-black text-lg text-white transition duration-200 hover:bg-gray-800 focus:ring-2 focus:ring-offset-2 focus:outline-none"
                type="submit"
                tabindex="5"
                :disabled="processing"
                data-test="register-user-button"
            >
                <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                Create account
            </Button>
        </Form>
        <div class="mt-[14px] text-center text-sm text-muted-foreground">
            By signing up, you agree to our Terms & Conditions.
        </div>
        <div class="mt-[49px] text-center text-sm text-muted-foreground">
            Already have an account?
            <a href="/login" class="cursor-pointer text-black"> Log in </a>
        </div>
    </AuthBase>
</template>
