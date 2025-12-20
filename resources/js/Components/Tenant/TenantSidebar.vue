<template>
  <aside class="sidebar">
    <div class="logo">
      <span>ClimaSAT</span>
    </div>

    <Menu :model="items" class="menu" />
  </aside>
</template>

<script setup>
import Menu from 'primevue/menu'
import { router } from '@inertiajs/vue3'

const go = (routeName) => {
  router.visit(route(routeName))
}

const items = [
  {
    label: 'Dashboard',
    icon: 'pi pi-home',
    command: () => go('tenant.dashboard')
  },
  {
    label: 'Clientes',
    icon: 'pi pi-building',
    command: () => go('clients.index')
  },
  {
    label: 'Técnicos',
    icon: 'pi pi-user',
    command: () => go('technicians.index')
  },
  {
    label: 'Tipo de Avería',
    icon: 'pi pi-wrench',
    command: () => go('fault-types.index')
  },
  {
    label: 'Tickets',
    icon: 'pi pi-ticket',
    command: () => go('tickets.index')
  },
  {
    label: 'Partes de Trabajo',
    icon: 'pi pi-clipboard',
    command: () => go('work-orders.index')
  },
  {
    label: 'Facturas',
    icon: 'pi pi-file',
    command: () => go('invoices.index')
  }
]
</script>

<style scoped>
.sidebar {
  width: 260px;
  background: var(--surface-card);
  border-right: 1px solid var(--surface-border);
  display: flex;
  flex-direction: column;
}

.logo {
  height: 64px;
  display: flex;
  align-items: center;
  padding: 0 1rem;
  font-weight: bold;
  font-size: 1.1rem;
  border-bottom: 1px solid var(--surface-border);
}

.menu {
  flex: 1;
  border: none;
}
</style>
