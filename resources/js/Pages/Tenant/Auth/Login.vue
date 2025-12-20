<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import Message from 'primevue/message';
import Card from 'primevue/card';

defineProps({
    canResetPassword: {
        type: Boolean,
        default: false,
    },
    status: {
        type: String,
    },
    tenant: {
        type: Object,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('tenant.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión - Tenant" />

        <div class="mb-6">
            <div class="flex items-center justify-center mb-4">
                <i class="pi pi-building text-5xl text-blue-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 text-center">
                Portal de Tenant
            </h3>
            <p class="text-sm text-gray-600 text-center mt-2">
                Accede a tu cuenta empresarial
            </p>
            <p v-if="tenant" class="text-xs text-blue-600 text-center mt-1 font-medium">
                {{ tenant.name }}
            </p>
        </div>

        <Message v-if="status" severity="success" :closable="false" class="mb-4">
            {{ status }}
        </Message>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Email Field -->
            <div class="flex flex-col gap-2">
                <label for="email" class="font-semibold text-gray-700 text-sm">
                    <i class="pi pi-envelope mr-1"></i>
                    Correo Electrónico
                </label>
                <InputText
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="usuario@empresa.com"
                    :invalid="!!form.errors.email"
                    autocomplete="username"
                    autofocus
                    fluid
                    class="w-full"
                />
                <small v-if="form.errors.email" class="text-red-600">
                    <i class="pi pi-exclamation-circle mr-1"></i>
                    {{ form.errors.email }}
                </small>
            </div>

            <!-- Password Field -->
            <div class="flex flex-col gap-2">
                <label for="password" class="font-semibold text-gray-700 text-sm">
                    <i class="pi pi-lock mr-1"></i>
                    Contraseña
                </label>
                <Password
                    id="password"
                    v-model="form.password"
                    placeholder="Ingresa tu contraseña"
                    :invalid="!!form.errors.password"
                    autocomplete="current-password"
                    :feedback="false"
                    toggleMask
                    fluid
                    inputClass="w-full"
                />
                <small v-if="form.errors.password" class="text-red-600">
                    <i class="pi pi-exclamation-circle mr-1"></i>
                    {{ form.errors.password }}
                </small>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Checkbox
                        v-model="form.remember"
                        inputId="remember"
                        :binary="true"
                    />
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer">
                        Recordarme
                    </label>
                </div>

                <Link
                    v-if="canResetPassword"
                    :href="route('tenant.password.request')"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium transition"
                >
                    <i class="pi pi-question-circle mr-1"></i>
                    ¿Olvidaste tu contraseña?
                </Link>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <Button
                    type="submit"
                    label="Iniciar Sesión"
                    :loading="form.processing"
                    :disabled="form.processing"
                    icon="pi pi-sign-in"
                    iconPos="right"
                    severity="primary"
                    fluid
                    size="large"
                    class="w-full"
                />
            </div>
        </form>

        <!-- Footer Info -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-center gap-2 text-xs text-gray-500">
                <i class="pi pi-shield"></i>
                <span>Conexión segura y encriptada</span>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
/* Estilos adicionales para el componente de tenant login */
:deep(.p-inputtext) {
    border-radius: 0.5rem;
}

:deep(.p-password) {
    width: 100%;
}

:deep(.p-password-input) {
    border-radius: 0.5rem;
    width: 100%;
}

:deep(.p-button) {
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

:deep(.p-button:hover) {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

:deep(.p-checkbox) {
    border-radius: 0.25rem;
}

:deep(.p-message) {
    border-radius: 0.5rem;
}
</style>
