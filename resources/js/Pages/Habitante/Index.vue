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
// import { initFlowbite } from 'flowbite'

const props = defineProps({
  habitantes: {
    type: Array,
    default: [],
  },
})

const swal = inject('$swal')

const datas = reactive({
  list: [],
  isLoad: false,
  query: '',
  dateStart: '',
  dateEnd: '',
})

const query = ref('')

const changeLoad = (value) => {
  datas.isLoad = value
}

const recargarPagina = () => {
  query.value = ''
  queryList('')
}

const onSearchQuery = (e) => {
  queryListSearchWeb(e.target.value)
}

onMounted(() => {
  // datas.list = props.datas
  queryList('')
  // getTipoDocumento(1)
})

const queryListSearchWeb = async (consulta) => {
  datas.isLoad = true
  console.log(consulta)
  const url = route('apphabitante.querySearchWeb', { query: consulta })
  await axios
    .post(url)
    .then((response) => {
      console.log(response.data)
      if (response.data.success) {
        datas.list = response.data.data
        /*for (const element of datas.list) {
          element.detalle = await getTipoDocumento(
            element.perfil.tipo_documento_id,
          )
        }*/
      }
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  datas.isLoad = false
}

const queryList = async (consulta) => {
  datas.isLoad = true
  const url = route('habitante.query', { query: consulta })
  await axios
    .post(url)
    .then(async (response) => {
      console.log(response)
      if (response.data.success) {
        datas.list = response.data.data
        /*for (const element of datas.list) {
          element.detalle = await getTipoDocumento(
            element.perfil.tipo_documento_id,
          )
        }*/
      } else {
        datas.list = []
      }
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  datas.isLoad = false
}

const destroyData = async (id) => {
  const url = route('habitante.destroy', id)
  await axios
    .delete(url)
    .then((response) => {
      swal.fire({
        title: response.data.success ? 'Buen Trabajo!' : 'Error!',
        text: response.data.success
          ? 'Dato creado exitosamente'
          : 'Algún error inesperado',
        icon: response.data.success ? 'success' : 'error',
      })
    })
    .catch((error) => {
      if (error.messageError) {
        console.log(error.message)
        swal.fire({
          title: error.messageError
            ? 'Error desde el micro servicio!'
            : 'Algun otro error esta sucediendo!',
          text: error.messageError
            ? 'Algunos datos fueron mal registrados'
            : 'Algun otro tipo de error sucedio',
          icon: error.messageError ? 'error' : 'success',
        })
      }
    })
  queryList('')
}

const fecha = (fechaData) => {
  return moment(fechaData).format('YYYY-MM-DD HH:MM:SS')
}

const getTipoDocumento = async (tipoDocumento_id) => {
  datas.isLoad = true
  var tipoDocumento
  const url = route('tipodocumento.show', { tipodocumento: tipoDocumento_id })
  await axios
    .get(url)
    .then((response) => {
      if (response.data.success) {
        tipoDocumento = response.data.data
      } else {
        tipoDocumento = 'Error en la consulta!..'
      }
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  datas.isLoad = false
  return tipoDocumento.detalle
}
</script>

<template>
  <AppLayout title="Residentes">
    <div class="flex flex-col">
      <div class="-m-1.5">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div
            class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700"
          >
            <!-- Header -->
            <HeaderIndex :title="'Residentes'">
              <template #link>
                <a
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                  :href="route('habitante.create')"
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
                      v-model="datas.dateStart"
                      :range="{ partialRange: false }"
                    />
                  </div>
                  <div class="col-end-7 col-span-2">
                    <div class="relative">
                      <label class="sr-only">Busqueda</label>
                      <input
                        v-model="datas.query"
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
                        Nombre
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
                <tr v-for="item in datas.list" :key="item.id">
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
                        NroDocumento: {{ item.nroDocumento }}
                      </span>
                      <span
                        class="block text-sm text-gray-500 dark:text-neutral-500"
                      >
                        Nro Vivienda: {{ item.nroVivienda }}
                      </span>
                    </div>
                  </td>
                  <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                      <span
                        class="block text-sm text-gray-500 dark:text-neutral-500"
                      >
                        {{ item.name }}
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
                      <span
                        :class="
                          item.isDuenho
                            ? 'text-teal-800 bg-teal-100 dark:text-teal-500'
                            : 'text-orange-800 bg-red-100 dark:text-orange-500'
                        "
                        class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-full dark:bg-teal-500/10"
                      >
                        <svg
                          class="size-2.5"
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"
                          />
                        </svg>
                        {{ item.isDuenho ? 'DUEÑO' : 'NO ES DUEÑO' }}
                      </span>
                    </div>
                  </td>
                  <td class="h-px w-72 whitespace-nowrap">
                    <div class="px-6 py-3">
                      <Link
                        :href="route('habitante.edit', item.id)"
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
