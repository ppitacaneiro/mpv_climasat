<template>
  <TenantLayout :tenant="tenant" :user="user">
    <div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-xl shadow-lg">
      <h1 class="text-2xl font-semibold mb-6 text-gray-800">
        Editar Ticket #{{ ticket.id }}
      </h1>

      <form @submit.prevent="submit" class="space-y-5">

        <!-- Cliente -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Cliente
          </label>
          <Dropdown
            v-model="form.client_id"
            :options="clients"
            optionLabel="name"
            optionValue="id"
            class="w-full"
            disabled
          />
        </div>

        <!-- Tipo de avería -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Tipo de avería
          </label>
          <Dropdown
            v-model="form.fault_type_id"
            :options="faultTypes"
            optionLabel="name"
            optionValue="id"
            class="w-full"
          />
        </div>

        <!-- Descripción -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Descripción
          </label>
          <Textarea
            v-model="form.description"
            rows="4"
            class="w-full"
          />
        </div>

        <!-- Sugerencia IA -->
        <div v-if="ticket.suggested_ia_solution">
          <label class="block mb-1 font-medium text-gray-700">
            Sugerencia de la IA
          </label>
          <Textarea
            v-model="form.suggested_ia_solution"
            rows="4"
            class="w-full bg-gray-50"
            readonly
          />
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

        <!-- Solución técnico -->
        <div>
          <label class="block mb-1 font-medium text-gray-700">
            Solución del técnico
          </label>
          <Textarea
            v-model="form.technician_solution"
            rows="4"
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
            label="Actualizar"
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
import Textarea from 'primevue/textarea'
import Dropdown from 'primevue/dropdown'
import Button from 'primevue/button'

const props = defineProps({
  tenant: Object,
  user: Object,
  ticket: Object,
  clients: Array,
  faultTypes: Array,
  statuses: Array,
  urgencies: Array,
})

const form = useForm({
  client_id: props.ticket.client_id,
  fault_type_id: props.ticket.fault_type_id,
  description: props.ticket.description,
  status: props.ticket.status,
  urgency: props.ticket.urgency,
  technician_solution: props.ticket.technician_solution,
  suggested_ia_solution: props.ticket.suggested_ia_solution,
})

const submit = () => {
  form.put(route('tickets.update', props.ticket.id), {
    preserveScroll: true,
  })
}
</script>
