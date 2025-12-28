<script setup>
import { useForm, router } from '@inertiajs/vue3'

import TenantLayout from '@/Layouts/TenantLayout.vue'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Dropdown from 'primevue/dropdown'
import Button from 'primevue/button'

const props = defineProps({
    tenant: Object,
    user: Object,
    priorities: Array, // [{ value: 'high', label: 'Alta' }, ...]
})

const form = useForm({
    name: '',
    description: '',
    priority: null,
})

const submit = () => {
    form.post(route('fault-types.store'), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <TenantLayout :tenant="tenant" :user="user">
        <div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-xl shadow-lg">
            <h1 class="text-2xl font-semibold mb-6 text-gray-800">
                Nuevo tipo de avería
            </h1>

            <!-- Error general -->
            <div
                v-if="form.errors.general"
                class="mb-4 rounded-md border border-red-300 bg-red-50 p-3 text-red-700"
            >
                {{ form.errors.general }}
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <!-- Nombre -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <InputText
                        v-model="form.name"
                        class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                        focus:outline-none focus:ring-2 focus:ring-blue-400"
                    />
                    <span v-if="form.errors.name" class="text-red-500 text-sm">
                        {{ form.errors.name }}
                    </span>
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Descripción
                    </label>
                    <Textarea
                        v-model="form.description"
                        rows="4"
                        class="w-full px-4 py-2 border-2 border-blue-600 rounded-md
                        focus:outline-none focus:ring-2 focus:ring-blue-400"
                    />
                </div>

                <!-- Prioridad -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">
                        Prioridad <span class="text-red-500">*</span>
                    </label>
                    <Dropdown
                        v-model="form.priority"
                        :options="priorities"
                        optionLabel="label"
                        optionValue="value"
                        placeholder="Selecciona una prioridad"
                        class="w-full border-2 border-blue-600 rounded-md"
                    />
                    <span v-if="form.errors.priority" class="text-red-500 text-sm">
                        {{ form.errors.priority }}
                    </span>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3 pt-4">
                    <Button
                        label="Cancelar"
                        class="px-6 py-2 border border-gray-300 text-gray-700 hover:bg-gray-100"
                        @click="router.visit(route('fault-types.index'))"
                    />
                    <Button
                        label="Guardar"
                        type="submit"
                        :loading="form.processing"
                        class="px-6 py-2 bg-blue-600 text-white hover:bg-blue-700 shadow-md"
                    />
                </div>
            </form>
        </div>
    </TenantLayout>
</template>