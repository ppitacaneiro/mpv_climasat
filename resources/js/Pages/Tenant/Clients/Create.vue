<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import TenantLayout from '@/Layouts/TenantLayout.vue'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Button from 'primevue/button'

const props = defineProps({
    tenant: Object,
    user: Object,
})

const form = useForm({
    name: '',
    tax_id: '',
    contact: '',
    phone: '',
    email: '',
    address: '',
    history: '',
})

const submit = () => {
    form.post(route('clients.store'), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <TenantLayout :tenant="tenant" :user="user">
        <!-- Card -->
        <div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-xl shadow-lg">
            <h1 class="text-2xl font-semibold mb-6 text-gray-800">
                Nuevo Cliente
            </h1>

            <div v-if="form.errors.general" class="mb-4 rounded-md border border-red-300 bg-red-50 p-3 text-red-700">
                {{ form.errors.general }}
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <!-- Nombre -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <InputText v-model="form.name" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <span v-if="form.errors.name" class="text-red-500 text-sm">
                        {{ form.errors.name }}
                    </span>
                </div>

                <!-- CIF / NIF -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        CIF / NIF
                    </label>
                    <InputText v-model="form.tax_id" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <!-- Contacto -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Persona de contacto
                    </label>
                    <InputText v-model="form.contact" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Teléfono <span class="text-red-500">*</span>
                    </label>
                    <InputText v-model="form.phone" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                   <span v-if="form.errors.phone" class="text-red-500 text-sm">
                        {{ form.errors.phone }}
                    </span>
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Email
                    </label>
                    <InputText v-model="form.email" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <!-- Dirección -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Dirección 
                    </label>
                    <Textarea v-model="form.address" rows="3" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <!-- Historial -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Historial
                    </label>
                    <Textarea v-model="form.history" rows="4" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3 pt-4">
                    <Button label="Cancelar" class="px-6 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100"
                        @click="router.visit(route('clients.index'))" />
                    <Button label="Guardar" type="submit" :loading="form.processing"
                        class="px-6 py-2 bg-blue-600 text-white hover:bg-blue-700 shadow-md" />
                </div>
            </form>
        </div>
    </TenantLayout>
</template>
