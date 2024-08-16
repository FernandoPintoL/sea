<script setup>
import { ref, onMounted, inject, reactive } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import List from './List.vue'
import SectionBorder from '@/Components/SectionBorder.vue'
import HeaderIndex from '@/Componentes/HeaderIndex.vue'
import TableGrl from '@/Componentes/Tbl-General.vue'
import moment from 'moment'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
  listado: {
    type: Array,
    default: [],
  },
})

const Swal = inject('$swal')

onMounted(() => {
  console.log(props.listado)
  reactives.list = props.listado
})

const changeLoad = (value) => {
  reactives.isLoad = value
}

const reactives = reactive({
  list: [],
  isLoad: false,
  query: '',
  dateStart: '',
  dateEnd: '',
})

const queryList = async (consulta) => {
  changeLoad(true)
  const url = route('condominio.query', { query: consulta })
  await axios
    .post(url)
    .then((response) => {
      // console.log(response.data)
      if (response.data.success) {
        reactives.list = response.data.data
      } else {
        reactives.list = []
      }
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  changeLoad(false)
}

const fecha = (fechaData) => {
  return moment(fechaData).format('YYYY-MM-DD HH:MM:SS')
}

const onSearchQuery = (e) => {
  queryList(e.target.value)
}
</script>

<template>
  <AppLayout title="Condominios">
    <div class="flex flex-col">
      <div class="-m-1.5">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div
            class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700"
          >
            <!-- Header -->
            <HeaderIndex :title="'Condominio'">
              <template #link>
                <a
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                  :href="route('condominio.create')"
                >
                  <svg
                    class="shrink-0 size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                  </svg>
                  Nuevo
                </a>
              </template>
            </HeaderIndex>
            <!-- End Header -->
            <!-- Table -->
            <TableGrl>
              <template #header-table>
                <div class="grid grid-cols-3 gap-4">
                  <div class="col-start-1 col-end-3">
                    <label class="text-sm text-gray-600 dark:text-neutral-400">
                      Rango de fechas
                    </label>
                    <VueDatePicker
                      v-model="reactives.dateStart"
                      :range="{ partialRange: false }"
                    />
                  </div>
                  <div class="col-end-7 col-span-2">
                    <div class="relative">
                      <label class="sr-only">Busqueda</label>
                      <input
                        type="text"
                        name="hs-table-with-pagination-search"
                        id="hs-table-with-pagination-search"
                        class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Buscar"
                      />
                      <div
                        class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3"
                      >
                        <svg
                          class="size-4 text-gray-400 dark:text-neutral-500"
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        >
                          <circle cx="11" cy="11" r="8"></circle>
                          <path d="m21 21-4.3-4.3"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
              <template #tbl-header>
                <tr>
                  <th
                    scope="col"
                    class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start"
                  >
                    <div class="flex items-center gap-x-2">
                      <span
                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200"
                      >
                        ID
                      </span>
                    </div>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span
                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200"
                      >
                        PROPIETARIO
                      </span>
                    </div>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span
                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200"
                      >
                        Creado
                      </span>
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span
                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200"
                      >
                        _
                      </span>
                    </div>
                  </th>
                </tr>
              </template>
              <template #tbl-body>
                <tr v-for="item in reactives.list" :key="item.id">
                  <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span
                        class="block text-sm font-semibold text-gray-800 dark:text-neutral-200"
                      >
                        #{{ item.id }}
                      </span>
                      <span
                        class="block text-sm font-semibold text-gray-800 dark:text-neutral-200"
                      >
                        NIT: {{ item.nit }}
                      </span>
                    </div>
                  </td>
                  <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span
                        class="block text-sm text-gray-500 dark:text-neutral-500"
                      >
                        {{ item.propietario }}
                      </span>
                      <span
                        class="block text-sm text-gray-500 dark:text-neutral-500"
                      >
                        Razon Social: {{ item.razonSocial }}
                      </span>
                    </div>
                  </td>
                  <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span
                        class="block text-sm text-gray-500 dark:text-neutral-500"
                      >
                        {{ fecha(item.created_at) }}
                      </span>
                    </div>
                  </td>
                  <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                      <Link
                        :href="route('condominio.edit', item.id)"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      >
                        Editar
                        <i class="fa-solid fa-pencil"></i>
                      </Link>
                    </div>
                  </td>
                </tr>
              </template>
            </TableGrl>
            <!-- End Table -->
          </div>
        </div>
      </div>
    </div>

    <!-- table -->
  </AppLayout>
</template>
