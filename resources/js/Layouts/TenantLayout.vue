<template>
  <div class="layout-wrapper">
    <!-- Sidebar -->
    <TenantSidebar />

    <!-- Main area -->
    <div class="layout-main">
      <!-- Topbar -->
      <TenantTopbar />

      <!-- Content -->
      <main class="layout-content">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import TenantSidebar from '@/components/Tenant/TenantSidebar.vue'
import TenantTopbar from '@/components/Tenant/TenantTopbar.vue'
</script>

<style scoped>
.layout-wrapper {
  display: flex;
  height: 100vh;
  overflow: hidden;
}

.layout-main {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.layout-content {
  flex: 1;
  padding: 1.5rem;
  background: var(--surface-ground);
  overflow-y: auto;
}
</style>
