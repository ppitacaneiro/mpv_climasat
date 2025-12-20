<template>
  <TenantLayout :tenant="tenant" :user="user">
    <div>
      <!-- Header -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Técnicos</h1>

        <!-- Nuevo técnico -->
        <Button
          label="Nuevo técnico"
          icon="pi pi-plus"
          class="bg-blue-600 text-white hover:bg-blue-700 px-5 py-2 rounded-md shadow-md"
          @click="router.visit(route('technicians.create'))"
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

      <!-- Flash messages -->
      <div v-if="$page.props.flash?.success" class="mb-4 p-3 rounded bg-green-100 text-green-800">
        {{ $page.props.flash.success }}
      </div>
      <div v-if="$page.props.flash?.error" class="mb-4 p-3 rounded bg-red-100 text-red-800">
        {{ $page.props.flash.error }}
      </div>

      <!-- DataTable -->
      <DataTable
        :value="technicians.data"
        lazy
        paginator
        :rows="technicians.per_page"
        :totalRecords="technicians.total"
        :first="(technicians.current_page - 1) * technicians.per_page"
        @page="onPage"
        stripedRows
        responsiveLayout="scroll"
        class="overflow-x-auto shadow-md rounded-lg bg-white"
      >
        <Column field="name" header="Nombre" sortable />
        <Column field="tax_id" header="CIF / NIF" />
        <Column field="specialty" header="Especialidad" />
        <Column field="phone" header="Teléfono" />
        <Column field="email" header="Email" />
        <Column field="availability" header="Disponibilidad" />

        <Column header="Acciones" :style="{ width: '160px' }">
          <template #body="{ data }">
            <div class="flex gap-2">
              <!-- Editar -->
              <Button
                icon="pi pi-pencil"
                text
                class="text-blue-600 hover:text-blue-800"
                rounded
                @click="router.visit(route('technicians.edit', data.id))"
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

    <!-- Confirm Dialog -->
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
  technicians: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
  tenant: { type: Object, required: true },
  user: { type: Object, required: true }
})

/* Search */
const search = ref(props.filters.search ?? '')
const confirm = useConfirm()

watch(search, (value) => {
  router.visit(route('technicians.index'), {
    data: { search: value },
    preserveState: true,
    preserveScroll: true,
    replace: true
  })
})

/* Pagination */
const onPage = (event) => {
  router.visit(route('technicians.index'), {
    data: { page: event.page + 1, search: search.value },
    preserveState: true,
    preserveScroll: true
  })
}

/* Confirmar eliminación */
const confirmDelete = (id) => {
  confirm.require({
    message: '¿Estás seguro de eliminar este técnico?',
    header: 'Confirmar eliminación',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Sí, eliminar',
    rejectLabel: 'Cancelar',
    accept: () => {
      router.delete(route('technicians.destroy', id), {
        preserveState: true,
        preserveScroll: true
      })
    }
  })
}
</script>
