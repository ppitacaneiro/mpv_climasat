<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
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
    <div class="max-w-2xl mx-auto p-4 bg-white rounded shadow">
        <h1 class="text-xl font-semibold mb-4">Nuevo Cliente</h1>

        <form @submit.prevent="submit" class="space-y-4">
            <!-- Nombre obligatorio -->
            <div>
                <label class="block mb-1">Nombre <span class="text-red-500">*</span></label>
                <InputText v-model="form.name" class="w-full" />
                <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
            </div>

            <!-- CIF / NIF opcional -->
            <div>
                <label class="block mb-1">CIF / NIF</label>
                <InputText v-model="form.tax_id" class="w-full" />
                <span v-if="form.errors.tax_id" class="text-red-500 text-sm">{{ form.errors.tax_id }}</span>
            </div>

            <!-- Contacto obligatorio -->
            <div>
                <label class="block mb-1">Persona de contacto <span class="text-red-500">*</span></label>
                <InputText v-model="form.contact" class="w-full" />
                <span v-if="form.errors.contact" class="text-red-500 text-sm">{{ form.errors.contact }}</span>
            </div>

            <!-- Teléfono opcional -->
            <div>
                <label class="block mb-1">Teléfono</label>
                <InputText v-model="form.phone" class="w-full" />
                <span v-if="form.errors.phone" class="text-red-500 text-sm">{{ form.errors.phone }}</span>
            </div>

            <!-- Email opcional -->
            <div>
                <label class="block mb-1">Email</label>
                <InputText v-model="form.email" class="w-full" />
                <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
            </div>

            <!-- Dirección obligatoria -->
            <div>
                <label class="block mb-1">Dirección <span class="text-red-500">*</span></label>
                <Textarea v-model="form.address" rows="3" class="w-full" />
                <span v-if="form.errors.address" class="text-red-500 text-sm">{{ form.errors.address }}</span>
            </div>

            <!-- Historial opcional -->
            <div>
                <label class="block mb-1">Historial</label>
                <Textarea v-model="form.history" rows="4" class="w-full" />
                <span v-if="form.errors.history" class="text-red-500 text-sm">{{ form.errors.history }}</span>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-2 mt-4">
                <Button label="Cancelar" text @click="$router.back()" />
                <Button label="Guardar" type="submit" :loading="form.processing" />
            </div>
        </form>
    </div>
  </TenantLayout>
</template>
