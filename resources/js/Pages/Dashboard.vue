<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Components/Welcome.vue'
import ListIngresos from '@/Pages/Ingreso/List.vue'
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        INGRESOS
      </h2>
    </template>

    <div class="py-12 w-full">
      <ListIngresos />
    </div>
    <!-- <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <Welcome />
        </div>
      </div>
    </div> -->
  </AppLayout>
</template>
