<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import TenantLayout from '@/Layouts/TenantLayout.vue'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'

const props = defineProps({
    tenant: Object,
    user: Object,
    technician: {
        type: Object,
        required: true
    }
})

const form = useForm({
    name: props.technician.name,
    tax_id: props.technician.tax_id,
    specialty: props.technician.specialty,
    phone: props.technician.phone,
    email: props.technician.email,
    availability: props.technician.availability,
})

const submit = () => {
    form.put(route('technicians.update', props.technician.id), {
        onSuccess: () => console.log('Técnico actualizado correctamente')
    })
}
</script>

<template>
<TenantLayout :tenant="tenant" :user="user">
    <div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-xl shadow-lg">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">
            Editar Técnico
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
                <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
            </div>

            <!-- CIF / NIF -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">
                    CIF / NIF
                </label>
                <InputText v-model="form.tax_id" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <!-- Especialidad -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">
                    Especialidad <span class="text-red-500">*</span>
                </label>
                <InputText v-model="form.specialty" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
                <span v-if="form.errors.specialty" class="text-red-500 text-sm">{{ form.errors.specialty }}</span>
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">
                    Teléfono
                </label>
                <InputText v-model="form.phone" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">
                    Email
                </label>
                <InputText v-model="form.email" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <!-- Disponibilidad -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">
                    Disponibilidad
                </label>
                <select v-model="form.availability" class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                   focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="available">Disponible</option>
                    <option value="busy">Ocupado</option>
                    <option value="off">Libre</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3 pt-4">
                <Button label="Cancelar" class="px-6 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100"
                    @click="router.visit(route('technicians.index'))" />
                <Button label="Guardar" type="submit" :loading="form.processing"
                    class="px-6 py-2 bg-blue-600 text-white hover:bg-blue-700 shadow-md" />
            </div>
        </form>
    </div>
</TenantLayout>
</template>
