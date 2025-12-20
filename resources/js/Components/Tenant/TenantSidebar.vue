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

const items = [
  {
    label: 'Dashboard',
    icon: 'pi pi-home',
    to: '/dashboard'
  },
  {
    label: 'Pacientes',
    icon: 'pi pi-users',
    to: '/patients'
  },
  {
    label: 'Citas',
    icon: 'pi pi-calendar',
    to: '/appointments'
  },
  {
    separator: true
  },
  {
    label: 'Configuración',
    icon: 'pi pi-cog',
    to: '/settings'
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
