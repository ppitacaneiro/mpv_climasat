<template>
  <header
    class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shadow-md"
  >
    <!-- Left: Tenant Name -->
    <div class="text-xl font-semibold text-gray-800">
      {{ tenantName }}
    </div>

    <!-- Right: User Info -->
    <div class="flex items-center gap-4 relative">
      <span class="font-medium text-gray-700">{{ user.name }}</span>

      <Avatar
        :label="initials"
        shape="circle"
        class="bg-blue-600 text-white"
      />

      <Menu ref="menu" :model="userMenu" popup />

      <Button
        icon="pi pi-chevron-down"
        text
        class="text-gray-600 hover:text-gray-800"
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
  { label: 'Perfil', icon: 'pi pi-user', to: '/profile' },
  { label: 'Cerrar sesión', icon: 'pi pi-sign-out', command: () => { /* logout */ } }
]

const toggle = (event) => {
  menu.value.toggle(event)
}
</script>
