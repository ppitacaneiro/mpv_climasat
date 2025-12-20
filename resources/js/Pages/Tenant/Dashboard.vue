<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Button from 'primevue/button';

const props = defineProps({
    tenant: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
});

const logoutForm = useForm({});

const logout = () => {
    logoutForm.post(route('tenant.logout'));
};
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <Head title="Dashboard - Tenant" />

        <!-- Header -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <i class="pi pi-building text-2xl text-blue-600 mr-3"></i>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">{{ tenant.name }}</h1>
                            <p class="text-xs text-gray-500">Portal Empresarial</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                            <p class="text-xs text-gray-500">{{ user.email }}</p>
                        </div>
                        <Button
                            @click="logout"
                            :loading="logoutForm.processing"
                            icon="pi pi-sign-out"
                            severity="danger"
                            text
                            rounded
                            v-tooltip.bottom="'Cerrar Sesión'"
                        />
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Welcome Card -->
                <Card class="mb-6">
                    <template #title>
                        <div class="flex items-center gap-3">
                            <i class="pi pi-check-circle text-green-500 text-2xl"></i>
                            <span>¡Bienvenido, {{ user.name }}!</span>
                        </div>
                    </template>
                    <template #content>
                        <p class="text-gray-600">
                            Has iniciado sesión exitosamente en el portal empresarial de <strong>{{ tenant.name }}</strong>.
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Tenant ID: {{ tenant.id }}
                        </p>
                    </template>
                </Card>

                <!-- Dashboard Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Card>
                        <template #title>
                            <div class="flex items-center gap-2">
                                <i class="pi pi-users text-blue-500"></i>
                                <span class="text-lg">Usuarios</span>
                            </div>
                        </template>
                        <template #content>
                            <p class="text-3xl font-bold text-gray-900">-</p>
                            <p class="text-sm text-gray-500 mt-2">Total de usuarios</p>
                        </template>
                    </Card>

                    <Card>
                        <template #title>
                            <div class="flex items-center gap-2">
                                <i class="pi pi-ticket text-green-500"></i>
                                <span class="text-lg">Tickets</span>
                            </div>
                        </template>
                        <template #content>
                            <p class="text-3xl font-bold text-gray-900">-</p>
                            <p class="text-sm text-gray-500 mt-2">Tickets activos</p>
                        </template>
                    </Card>

                    <Card>
                        <template #title>
                            <div class="flex items-center gap-2">
                                <i class="pi pi-cog text-purple-500"></i>
                                <span class="text-lg">Configuración</span>
                            </div>
                        </template>
                        <template #content>
                            <p class="text-sm text-gray-600">
                                Administra la configuración de tu empresa
                            </p>
                            <Button
                                label="Configurar"
                                icon="pi pi-arrow-right"
                                iconPos="right"
                                text
                                class="mt-3 p-0"
                            />
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
:deep(.p-card) {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border-radius: 0.5rem;
}

:deep(.p-card-title) {
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
}

:deep(.p-card-content) {
    padding-top: 0;
}
</style>
