<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirmar Contraseña" />

        <div class="mb-6 text-center">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">
                Área Segura
            </h3>
        </div>

        <div class="mb-6 text-sm text-gray-600 text-center bg-blue-50 p-4 rounded-lg">
            Esta es un área segura de la aplicación. Por favor confirma tu
            contraseña antes de continuar.
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel for="password" value="Contraseña" class="font-semibold" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="pt-2">
                <PrimaryButton
                    class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-[1.02]"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirmar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
