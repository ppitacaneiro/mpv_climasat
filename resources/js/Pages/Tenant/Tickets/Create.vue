<template>
  <TenantLayout :tenant="tenant" :user="user">
    <div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-xl shadow-lg">
      <h1 class="text-2xl font-semibold mb-6 text-gray-800">
        Nuevo Ticket
      </h1>

      <form @submit.prevent="submit" class="space-y-5">

        <!-- Cliente -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Cliente <span class="text-red-500">*</span>
          </label>
          <Dropdown
            v-model="form.client_id"
            :options="clients"
            optionLabel="name"
            optionValue="id"
            placeholder="Selecciona un cliente"
            class="w-full"
          />
          <span v-if="form.errors.client_id" class="text-red-500 text-sm">
            {{ form.errors.client_id }}
          </span>
        </div>

        <!-- Tipo de avería -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Tipo de avería <span class="text-red-500">*</span>
          </label>
          <Dropdown
            v-model="form.fault_type_id"
            :options="faultTypes"
            optionLabel="name"
            optionValue="id"
            placeholder="Selecciona una avería"
            class="w-full"
          />
          <span v-if="form.errors.fault_type_id" class="text-red-500 text-sm">
            {{ form.errors.fault_type_id }}
          </span>
        </div>

        <!-- Descripción -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Descripción <span class="text-red-500">*</span>
          </label>
          <Textarea
            v-model="form.description"
            rows="4"
            class="w-full"
          />
          <span v-if="form.errors.description" class="text-red-500 text-sm">
            {{ form.errors.description }}
          </span>
        </div>

        <!-- Estado -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Estado
          </label>
          <Dropdown
            v-model="form.status"
            :options="statuses"
            optionLabel="label"
            optionValue="value"
            class="w-full"
          />
        </div>

        <!-- Urgencia -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Urgencia
          </label>
          <Dropdown
            v-model="form.urgency"
            :options="urgencies"
            optionLabel="label"
            optionValue="value"
            class="w-full"
          />
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3 pt-4">
          <Button
            label="Cancelar"
            class="px-6 py-2 border border-gray-300 text-gray-700"
            @click="router.visit(route('tickets.index'))"
          />
          <Button
            label="Guardar"
            type="submit"
            :loading="form.processing"
            class="px-6 py-2 bg-blue-600 text-white"
          />
        </div>

      </form>
    </div>
  </TenantLayout>
</template>
<script setup>
import { useForm, router } from '@inertiajs/vue3'
import TenantLayout from '@/Layouts/TenantLayout.vue'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Dropdown from 'primevue/dropdown'
import Button from 'primevue/button'

const props = defineProps({
  tenant: Object,
  user: Object,
  clients: Array,
  faultTypes: Array,
  statuses: Array,   // [{ value, label }]
  urgencies: Array,  // [{ value, label }]
})

const form = useForm({
  client_id: null,
  fault_type_id: null,
  description: '',
  status: 'open',
  urgency: 'medium',
})

const submit = () => {
  form.post(route('tickets.store'), {
    preserveScroll: true,
  })
}
</script>
