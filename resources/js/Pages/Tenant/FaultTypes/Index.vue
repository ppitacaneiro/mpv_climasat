<template>
  <TenantLayout :tenant="tenant" :user="user">
    <div>
      <!-- Header -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold">Tipos de avería</h1>

        <!-- Nuevo tipo -->
        <Button
          label="Nuevo tipo"
          icon="pi pi-plus"
          class="bg-blue-600 text-white hover:bg-blue-700 px-5 py-2 rounded-md shadow-md"
          @click="router.visit(route('fault-types.create'))"
        />
      </div>

      <!-- Search -->
      <div class="mb-4 max-w-sm">
        <InputText
          v-model="search"
          placeholder="Buscar por nombre, descripción o prioridad..."
          class="w-full px-4 py-2 border-2 border-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <!-- Flash messages -->
      <div
        v-if="$page.props.flash?.success"
        class="mb-4 p-3 rounded bg-green-100 text-green-800"
      >
        {{ $page.props.flash.success }}
      </div>

      <div
        v-if="$page.props.flash?.error"
        class="mb-4 p-3 rounded bg-red-100 text-red-800"
      >
        {{ $page.props.flash.error }}
      </div>

      <!-- DataTable -->
      <DataTable
        :value="faultTypes.data"
        lazy
        paginator
        :rows="faultTypes.per_page"
        :totalRecords="faultTypes.total"
        :first="(faultTypes.current_page - 1) * faultTypes.per_page"
        @page="onPage"
        stripedRows
        responsiveLayout="scroll"
        class="overflow-x-auto shadow-md rounded-lg bg-white"
      >
        <Column field="name" header="Nombre" sortable />
        <Column field="description" header="Descripción" />
        <Column field="priority_label" header="Prioridad" />

        <Column header="Acciones" :style="{ width: '160px' }">
          <template #body="{ data }">
            <div class="flex gap-2">
              <!-- Editar -->
              <Button
                icon="pi pi-pencil"
                text
                class="text-blue-600 hover:text-blue-800"
                rounded
                @click="router.visit(route('fault-types.edit', data.id))"
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
import { useConfirm } from 'primevue/useconfirm'

const props = defineProps({
  faultTypes: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
  tenant: { type: Object, required: true },
  user: { type: Object, required: true }
})

/* Search */
const search = ref(props.filters.search ?? '')
const confirm = useConfirm()

watch(search, (value) => {
  router.visit(route('fault-types.index'), {
    data: { search: value },
    preserveState: true,
    preserveScroll: true,
    replace: true
  })
})

/* Pagination */
const onPage = (event) => {
  router.visit(route('fault-types.index'), {
    data: {
      page: event.page + 1,
      search: search.value
    },
    preserveState: true,
    preserveScroll: true
  })
}

/* Confirmar eliminación */
const confirmDelete = (id) => {
  confirm.require({
    message: '¿Estás seguro de eliminar este tipo de avería?',
    header: 'Confirmar eliminación',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Sí, eliminar',
    rejectLabel: 'Cancelar',
    accept: () => {
      router.delete(route('fault-types.destroy', id), {
        preserveState: true,
        preserveScroll: true
      })
    }
  })
}
</script>
