<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import List from './List.vue'
import SectionBorder from '@/Components/SectionBorder.vue'
// import { initFlowbite } from 'flowbite'

const props = defineProps({
  habitantes: {
    type: Array,
    default: [],
  },
})
</script>

<template>
  <AppLayout title="Habitantes">
    <template #header>
      <div
        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
      >
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          GESTION HUESPEDES-HABITANTES
        </h2>
        <div class="flex-1 ms-8 whitespace-nowrap">
          <Link
            :href="route('habitante.create')"
            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
          >
            Crear nuevo Habitante
          </Link>
        </div>
      </div>
    </template>
    <div class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8">
      <List />
    </div>
  </AppLayout>
</template>
