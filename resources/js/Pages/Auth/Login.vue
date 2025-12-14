<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión" />

        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-800 text-center">
                Iniciar Sesión
            </h3>
            <p class="text-sm text-gray-600 text-center mt-2">
                Accede a tu cuenta ClimaSAT
            </p>
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600 bg-green-50 p-3 rounded-lg">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel for="email" value="Correo Electrónico" class="font-semibold" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="tu@email.com"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Contraseña" class="font-semibold" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Recordarme</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium transition"
                >
                    ¿Olvidaste tu contraseña?
                </Link>
            </div>

            <div class="pt-2">
                <PrimaryButton
                    class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Iniciar Sesión
                </PrimaryButton>
            </div>

            <div class="text-center pt-2 border-t border-gray-200">
                <p class="text-sm text-gray-600 mt-4">
                    ¿No tienes cuenta?
                    <Link
                        :href="route('register')"
                        class="text-blue-600 hover:text-blue-700 font-semibold transition"
                    >
                        Regístrate gratis
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
