<template>
  <TenantLayout :tenant="tenant" :user="user">
    <div>
      <!-- Header -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Tickets</h1>

        <!-- Nuevo ticket -->
        <Button
          label="Nuevo ticket"
          icon="pi pi-plus"
          class="bg-blue-600 text-white hover:bg-blue-700 px-5 py-2 rounded-md shadow-md"
          @click="router.visit(route('tickets.create'))"
        />
      </div>

      <!-- Search -->
      <div class="mb-4 max-w-sm">
        <InputText
          v-model="search"
          placeholder="Buscar por nombre, email, teléfono..."
          class="w-full px-4 py-2 border-2 border-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <div v-if="$page.props.flash?.success" class="mb-4 p-3 rounded bg-green-100 text-green-800">
        {{ $page.props.flash.success }}
      </div>

      <div v-if="$page.props.flash?.error" class="mb-4 p-3 rounded bg-red-100 text-red-800">
        {{ $page.props.flash.error }}
      </div>

      <!-- DataTable -->
      <DataTable
        :value="tickets.data"
        lazy
        paginator
        :rows="tickets.per_page"
        :totalRecords="tickets.total"
        :first="(tickets.current_page - 1) * tickets.per_page"
        @page="onPage"
        stripedRows
        responsiveLayout="scroll"
        class="overflow-x-auto shadow-md rounded-lg bg-white"
      >
        <!-- ID Ticket -->
        <Column field="id" header="Ticket #" sortable />

        <!-- Estado -->
        <Column field="status" header="Estado" sortable>
          <template #body="{ data }">
            <span
              class="px-2 py-1 rounded text-sm font-medium"
            >
              {{ data.status_label }}
            </span>
          </template>
        </Column>

        <!-- Cliente -->
        <Column header="Cliente" sortable>
          <template #body="{ data }">
            {{ data.client?.name ?? '—' }}
          </template>
        </Column>

        <!-- Teléfono -->
        <Column header="Teléfono">
          <template #body="{ data }">
            {{ data.client?.phone ?? '—' }}
          </template>
        </Column>

        <!-- Fecha creación -->
        <Column field="created_at" header="Creado el" sortable>
          <template #body="{ data }">
            {{ new Date(data.created_at).toLocaleDateString() }}
          </template>
        </Column>

        <!-- Urgencia -->
        <Column field="urgency" header="Urgencia" sortable>
          <template #body="{ data }">
            <span
              class="px-2 py-1 rounded text-sm font-medium"
            >
              {{ data.urgency_label }}
            </span>
          </template>
        </Column>

        <!-- Acciones -->
        <Column header="Acciones" :style="{ width: '140px' }">
          <template #body="{ data }">
            <div class="flex gap-2">
              <Button
                icon="pi pi-pencil"
                text
                class="text-blue-600 hover:text-blue-800"
                rounded
                @click="router.visit(route('tickets.edit', data.id))"
              />
              <Button
                icon="pi pi-trash"
                text
                class="text-red-600 hover:text-red-800"
                rounded
                @click="confirmDelete(data.id)"
              />
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
    <ConfirmDialog />
  </TenantLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

import TenantLayout from '@/Layouts/TenantLayout.vue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import ConfirmDialog from 'primevue/confirmdialog'
import { useConfirm } from "primevue/useconfirm";

const props = defineProps({
  tickets: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
  tenant: { type: Object, required: true },
  user: { type: Object, required: true }
})

/* Search */
const search = ref(props.filters.search ?? '')

const confirm = useConfirm()

watch(search, (value) => {
  router.visit(route('tickets.index'), {
    data: { search: value },
    preserveState: true,
    preserveScroll: true,
    replace: true
  })
})

/* Pagination */
const onPage = (event) => {
  router.visit(route('tickets.index'), {
    data: { page: event.page + 1, search: search.value },
    preserveState: true,
    preserveScroll: true
  })
}

/* Confirmar eliminación */
const confirmDelete = (id) => {
  confirm.require({
    message: '¿Estás seguro de eliminar este cliente?',
    header: 'Confirmar eliminación',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Sí, eliminar',
    rejectLabel: 'Cancelar',
    accept: () => {
      router.delete(route('tickets.destroy', id), {
        preserveState: true,
        preserveScroll: true
      })
    }
  })
}
</script>
