<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Verificación de Correo Electrónico" />

        <div class="mb-6 text-center">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">
                Verifica tu Correo
            </h3>
        </div>

        <div class="mb-4 text-sm text-gray-600 text-center bg-blue-50 p-4 rounded-lg">
            ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu
            dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte? Si no
            recibiste el correo, con gusto te enviaremos otro.
        </div>

        <div
            class="mb-4 text-sm font-medium text-green-700 bg-green-50 p-4 rounded-lg text-center"
            v-if="verificationLinkSent"
        >
            ✓ Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que
            proporcionaste durante el registro.
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div class="pt-2">
                <PrimaryButton
                    class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reenviar Correo de Verificación
                </PrimaryButton>
            </div>

            <div class="text-center pt-2 border-t border-gray-200">
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-gray-600 hover:text-gray-900 font-medium transition mt-4 inline-block"
                >
                    Cerrar Sesión
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
