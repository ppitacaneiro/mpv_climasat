<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="relative flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-blue-600 via-blue-500 to-blue-600"
    >
        <div class="absolute inset-0 bg-blue-600/10 backdrop-blur-3xl"></div>
        
        <div class="relative z-10 w-full max-w-md px-6">
            <div class="mb-8 text-center">
                <Link href="/" class="inline-block">
                    <h1 class="text-4xl font-extrabold text-white drop-shadow-lg tracking-tight">
                        ClimaSAT
                    </h1>
                    <p class="text-sm text-white/80 mt-1">Sistema de Gestión HVAC</p>
                </Link>
            </div>

            <div
                class="overflow-hidden bg-white/95 backdrop-blur-sm px-8 py-8 shadow-2xl rounded-3xl border border-white/20"
            >
                <slot />
            </div>

            <div class="mt-6 text-center">
                <Link
                    href="/"
                    class="text-sm text-white/90 hover:text-white underline transition"
                >
                    Volver al inicio
                </Link>
            </div>
        </div>

        <footer class="absolute bottom-4 text-center text-sm text-white/70">
            ClimaSAT &copy; 2026. Todos los derechos reservados.
        </footer>
    </div>
</template>

<style scoped>
.bg-gradient-to-br {
    background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #2563eb 100%);
}
</style>
