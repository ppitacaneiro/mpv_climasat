<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Restablecer Contraseña" />

        <div class="mb-6 text-center">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">
                Restablecer Contraseña
            </h3>
            <p class="text-sm text-gray-600 mt-2">
                Ingresa tu nueva contraseña
            </p>
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
                <InputLabel for="password" value="Nueva Contraseña" class="font-semibold" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Mínimo 8 caracteres"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar Contraseña"
                    class="font-semibold"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Repite tu contraseña"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="pt-2">
                <PrimaryButton
                    class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Restablecer Contraseña
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
