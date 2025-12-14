<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    company_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Registro" />

        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-800 text-center">
                Crear Cuenta
            </h3>
            <p class="text-sm text-gray-600 text-center mt-2">
                Únete a ClimaSAT y optimiza tu SAT HVAC
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel for="name" value="Nombre Completo" class="font-semibold" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Juan Pérez"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="company_name" value="Nombre de la Empresa" class="font-semibold" />

                <TextInput
                    id="company_name"
                    type="text"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.company_name"
                    required
                    autocomplete="organization"
                    placeholder="Mi Empresa HVAC"
                />

                <InputError class="mt-2" :message="form.errors.company_name" />
            </div>

            <div>
                <InputLabel for="email" value="Correo Electrónico" class="font-semibold" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.email"
                    required
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
                    Crear Cuenta
                </PrimaryButton>
            </div>

            <div class="text-center pt-2 border-t border-gray-200">
                <p class="text-sm text-gray-600 mt-4">
                    ¿Ya tienes cuenta?
                    <Link
                        :href="route('login')"
                        class="text-blue-600 hover:text-blue-700 font-semibold transition"
                    >
                        Inicia sesión
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
