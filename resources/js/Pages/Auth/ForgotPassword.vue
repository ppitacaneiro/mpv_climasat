<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Recuperar Contraseña" />

        <div class="mb-6 text-center">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">
                ¿Olvidaste tu contraseña?
            </h3>
        </div>

        <div class="mb-4 text-sm text-gray-600 text-center bg-blue-50 p-4 rounded-lg">
            No hay problema. Indícanos tu dirección de correo electrónico y te enviaremos
            un enlace para restablecer tu contraseña.
        </div>

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-700 bg-green-50 p-4 rounded-lg text-center"
        >
            ✓ {{ status }}
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

            <div class="pt-2">
                <PrimaryButton
                    class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Enviar Enlace de Recuperación
                </PrimaryButton>
            </div>

            <div class="text-center pt-2 border-t border-gray-200">
                <p class="text-sm text-gray-600 mt-4">
                    ¿Recordaste tu contraseña?
                    <Link
                        :href="route('login')"
                        class="text-blue-600 hover:text-blue-700 font-semibold transition"
                    >
                        Iniciar sesión
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
