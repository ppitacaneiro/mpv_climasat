<template>
  <aside
    :class="[
      'flex flex-col h-full transition-transform duration-300 lg:translate-x-0 lg:w-64',
      isOpen ? 'translate-x-0' : '-translate-x-full',
      'bg-gradient-to-b from-blue-600 to-blue-500 text-white shadow-lg fixed lg:static z-30'
    ]"
  >
    <!-- Logo -->
    <div class="h-16 flex items-center px-4 font-bold text-lg border-b border-blue-400">
      ClimaSAT
    </div>

    <!-- Menu -->
    <div class="flex-1 overflow-y-auto">
      <Menu :model="items" class="p-4" />
    </div>
  </aside>
</template>

<script setup>
import { ref } from 'vue'
import Menu from 'primevue/menu'
import { router } from '@inertiajs/vue3'

const isOpen = ref(false)

const toggleSidebar = () => {
  isOpen.value = !isOpen.value
}

const go = (routeName) => {
  router.visit(route(routeName))
}

const items = [
  { label: 'Dashboard', icon: 'pi pi-home', command: () => go('tenant.dashboard') },
  { label: 'Clientes', icon: 'pi pi-building', command: () => go('clients.index') },
  { label: 'Técnicos', icon: 'pi pi-user', command: () => go('technicians.index') },
  { label: 'Tipo de Avería', icon: 'pi pi-wrench', command: () => go('fault-types.index') },
  { label: 'Tickets', icon: 'pi pi-ticket', command: () => go('tickets.index') },
  { label: 'Partes de Trabajo', icon: 'pi pi-clipboard', command: () => go('work-orders.index') },
  { label: 'Facturas', icon: 'pi pi-file', command: () => go('invoices.index') }
]
</script>
