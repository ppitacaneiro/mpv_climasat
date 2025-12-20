<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'

import TenantLayout from '@/Layouts/TenantLayout.vue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'

const props = defineProps({
    clients: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    tenant: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
})

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/
const search = ref(props.filters.search ?? '')

watch(search, (value) => {
    router.visit(route('clients.index'), {
        data: {
            search: value,
        },
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
})

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/
const onPage = (event) => {
    router.visit(route('clients.index'), {
        data: {
            page: event.page + 1,
            search: search.value,
        },
        preserveState: true,
        preserveScroll: true,
    })
}
</script>

<template>
  <TenantLayout :tenant="tenant" :user="user">
    <div>
        <!-- Header dentro del layout -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Clientes</h1>

            <Button
                label="Nuevo cliente"
                icon="pi pi-plus"
                @click="router.visit(route('clients.create'))"
            />
        </div>

        <!-- Search -->
        <div class="mb-4 max-w-sm">
            <InputText
                v-model="search"
                placeholder="Buscar por nombre, email, teléfono..."
                class="w-full"
            />
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
        >
            <Column field="name" header="Nombre" sortable />
            <Column field="tax_id" header="CIF / NIF" />
            <Column field="email" header="Email" />
            <Column field="phone" header="Teléfono" />

            <Column header="Acciones" :style="{ width: '120px' }">
                <template #body="{ data }">
                    <Button
                        icon="pi pi-pencil"
                        text
                        rounded
                        @click="router.visit(route('clients.edit', data.id))"
                    />
                </template>
            </Column>
        </DataTable>
    </div>
  </TenantLayout>
</template>
