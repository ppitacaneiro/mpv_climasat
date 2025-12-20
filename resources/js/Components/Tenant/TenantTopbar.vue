<template>
  <header class="topbar">
    <div class="left">
      <h2>{{ tenantName }}</h2>
    </div>

    <div class="right">
      <span class="user-name">{{ user.name }}</span>

      <Avatar
        :label="initials"
        shape="circle"
        class="avatar"
      />

      <Menu ref="menu" :model="userMenu" popup />
      <Button
        icon="pi pi-chevron-down"
        text
        @click="toggle"
      />
    </div>
  </header>
</template>

<script setup>
import { ref, computed } from 'vue'
import Avatar from 'primevue/avatar'
import Menu from 'primevue/menu'
import Button from 'primevue/button'

const tenantName = 'Clínica Demo'

const user = {
  name: 'Juan Pérez'
}

const initials = computed(() =>
  user.name
    .split(' ')
    .map(n => n[0])
    .join('')
)

const menu = ref(null)

const userMenu = [
  {
    label: 'Perfil',
    icon: 'pi pi-user',
    to: '/profile'
  },
  {
    label: 'Cerrar sesión',
    icon: 'pi pi-sign-out',
    command: () => {
      // logout
    }
  }
]

const toggle = (event) => {
  menu.value.toggle(event)
}
</script>

<style scoped>
.topbar {
  height: 64px;
  background: var(--surface-card);
  border-bottom: 1px solid var(--surface-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1.5rem;
}

.right {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.user-name {
  font-weight: 500;
}

.avatar {
  background: var(--primary-color);
  color: white;
}
</style>
