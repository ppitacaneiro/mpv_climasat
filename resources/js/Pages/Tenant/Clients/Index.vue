<template>
  <TenantLayout :tenant="tenant" :user="user">
    <div>
      <!-- Header -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Clientes</h1>

        <!-- Nuevo cliente -->
        <Button
          label="Nuevo cliente"
          icon="pi pi-plus"
          class="bg-blue-600 text-white hover:bg-blue-700 px-5 py-2 rounded-md shadow-md"
          @click="router.visit(route('clients.create'))"
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
        :value="clients.data"
        lazy
        paginator
        :rows="clients.per_page"
        :totalRecords="clients.total"
        :first="(clients.current_page - 1) * clients.per_page"
        @page="onPage"
        stripedRows
        responsiveLayout="scroll"
        class="overflow-x-auto shadow-md rounded-lg bg-white"
      >
        <Column field="name" header="Nombre" sortable />
        <Column field="tax_id" header="CIF / NIF" />
        <Column field="email" header="Email" />
        <Column field="phone" header="Teléfono" />

        <Column header="Acciones" :style="{ width: '160px' }">
          <template #body="{ data }">
            <div class="flex gap-2">
              <!-- Editar -->
              <Button
                icon="pi pi-pencil"
                text
                class="text-blue-600 hover:text-blue-800"
                rounded
                @click="router.visit(route('clients.edit', data.id))"
              />

              <!-- Eliminar -->
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

const props = defineProps({
  clients: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
  tenant: { type: Object, required: true },
  user: { type: Object, required: true }
})

/* Search */
const search = ref(props.filters.search ?? '')

watch(search, (value) => {
  router.visit(route('clients.index'), {
    data: { search: value },
    preserveState: true,
    preserveScroll: true,
    replace: true
  })
})

/* Pagination */
const onPage = (event) => {
  router.visit(route('clients.index'), {
    data: { page: event.page + 1, search: search.value },
    preserveState: true,
    preserveScroll: true
  })
}

/* Confirmar eliminación */
const confirmDelete = (id) => {
  if (confirm('¿Estás seguro de eliminar este cliente?')) {
    router.delete(route('clients.destroy', id), {
      preserveState: true,
      preserveScroll: true
    })
  }
}
</script>
