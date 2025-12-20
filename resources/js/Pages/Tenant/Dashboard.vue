<script setup>
import { Head } from '@inertiajs/vue3'
import Card from 'primevue/card'
import Button from 'primevue/button'
import TenantLayout from '@/Layouts/TenantLayout.vue'

defineProps({
    tenant: Object,
    user: Object,
})
</script>

<template>
    <TenantLayout :tenant="tenant" :user="user">
        <Head title="Dashboard - Tenant" />

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
                    Has iniciado sesión exitosamente en el portal empresarial de
                    <strong>{{ tenant.name }}</strong>.
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
                        <span>Usuarios</span>
                    </div>
                </template>
                <template #content>
                    <p class="text-3xl font-bold">-</p>
                    <p class="text-sm text-gray-500">Total de usuarios</p>
                </template>
            </Card>

            <Card>
                <template #title>
                    <div class="flex items-center gap-2">
                        <i class="pi pi-ticket text-green-500"></i>
                        <span>Tickets</span>
                    </div>
                </template>
                <template #content>
                    <p class="text-3xl font-bold">-</p>
                    <p class="text-sm text-gray-500">Tickets activos</p>
                </template>
            </Card>

            <Card>
                <template #title>
                    <div class="flex items-center gap-2">
                        <i class="pi pi-cog text-purple-500"></i>
                        <span>Configuración</span>
                    </div>
                </template>
                <template #content>
                    <Button
                        label="Configurar"
                        icon="pi pi-arrow-right"
                        iconPos="right"
                        text
                    />
                </template>
            </Card>
        </div>
    </TenantLayout>
</template>
