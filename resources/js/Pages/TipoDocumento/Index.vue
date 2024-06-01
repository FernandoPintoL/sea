<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import InformationForm from './List.vue'
import SectionBorder from '@/Components/SectionBorder.vue'
// import { initFlowbite } from 'flowbite'

const props = defineProps({
  tipodocumentos: {
    type: Array,
    default: [],
  },
})
</script>

<template>
  <AppLayout title="Tipo Documento">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        GESTION / TIPO DE DOCUMENTO
      </h2>
    </template>
    <div class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <InformationForm :tipodocumentos="props.tipodocumentos" />
      </div>
      <SectionBorder />
    </div>
  </AppLayout>
</template>
