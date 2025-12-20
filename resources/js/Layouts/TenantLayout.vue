<template>
  <div class="flex h-screen overflow-hidden font-sans">
    <!-- Sidebar -->
    <TenantSidebar
      class="w-64 bg-gradient-to-b from-blue-600 to-blue-500 text-white flex flex-col p-4 shadow-lg hidden lg:flex"
    />

    <!-- Main area -->
    <div class="flex-1 flex flex-col min-h-0">
      <!-- Topbar -->
      <TenantTopbar class="h-16 bg-white flex items-center px-6 shadow-md z-10" />

      <!-- Content -->
      <main class="flex-1 p-6 overflow-y-auto bg-gray-100">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import TenantSidebar from '@/components/Tenant/TenantSidebar.vue'
import TenantTopbar from '@/components/Tenant/TenantTopbar.vue'
</script>
