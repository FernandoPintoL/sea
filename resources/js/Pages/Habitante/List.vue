<script setup>
import { ref, onMounted, inject, reactive } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import FormSection from '@/Components/FormSection.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import ActionMessage from '@/Components/ActionMessage.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import moment from 'moment'

/* const props = defineProps({
  datas: {
    type: Array,
    default: [],
  },
}) */

const swal = inject('$swal')

const datas = reactive({
  list: [],
  isLoad: false,
})
onMounted(() => {
  // datas.list = props.datas
  queryList('')
  // getTipoDocumento(1)
})
const queryList = async (consulta) => {
  datas.isLoad = true
  const url = route('habitante.query', { query: consulta })
  await axios
    .post(url)
    .then(async (response) => {
      if (response.data.success) {
        datas.list = response.data.data
        for (const element of datas.list) {
          element.detalle = await getTipoDocumento(
            element.perfil.tipo_documento_id,
          )
        }
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
  <div v-if="datas.isLoad" class="p-6">
    <div class="mb-1 text-base font-medium dark:text-white">Cargando...</div>
    <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
      <div
        class="bg-blue-600 h-1.5 rounded-full dark:bg-blue-500"
        style="width: 45%;"
      ></div>
    </div>
  </div>
  <div v-else>
    <div v-if="datas.list.length > 0" class="p-8">
      <div class="relative overflow-x-auto">
        <div
          class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
        >
          <div>
            <!-- Dropdown menu -->
            <div
              id="dropdownRadio"
              class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
              data-popper-reference-hidden=""
              data-popper-escaped=""
              data-popper-placement="top"
              style="
                position: absolute;
                inset: auto auto 0px 0px;
                margin: 0px;
                transform: translate3d(522.5px, 3847.5px, 0px);
              "
            >
              <ul
                class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownRadioButton"
              >
                <li>
                  <div
                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                  >
                    <input
                      id="filter-radio-example-1"
                      type="radio"
                      value=""
                      name="filter-radio"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="filter-radio-example-1"
                      class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >
                      Last day
                    </label>
                  </div>
                </li>
                <li>
                  <div
                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                  >
                    <input
                      checked=""
                      id="filter-radio-example-2"
                      type="radio"
                      value=""
                      name="filter-radio"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="filter-radio-example-2"
                      class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >
                      Last 7 days
                    </label>
                  </div>
                </li>
                <li>
                  <div
                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                  >
                    <input
                      id="filter-radio-example-3"
                      type="radio"
                      value=""
                      name="filter-radio"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="filter-radio-example-3"
                      class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >
                      Last 30 days
                    </label>
                  </div>
                </li>
                <li>
                  <div
                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                  >
                    <input
                      id="filter-radio-example-4"
                      type="radio"
                      value=""
                      name="filter-radio"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="filter-radio-example-4"
                      class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >
                      Last month
                    </label>
                  </div>
                </li>
                <li>
                  <div
                    class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                  >
                    <input
                      id="filter-radio-example-5"
                      type="radio"
                      value=""
                      name="filter-radio"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="filter-radio-example-5"
                      class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >
                      Last year
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <label for="table-search" class="sr-only">Busqueda</label>
          <div class="relative">
            <div
              class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none"
            >
              <svg
                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </div>
            <input
              type="text"
              id="table-search"
              class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Search for items"
            />
          </div>
          <!-- <Link
            :href="route('tipodocumento.create')"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          >
            Crear
          </Link> -->

          <button
            type="button"
            @click="queryList('')"
            class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
          >
            Refrescar
          </button>
        </div>
        <!-- TABLA DE DATOS -->
        <table
          class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3">
                ID
              </th>
              <th scope="col" class="px-6 py-3">
                name
              </th>
              <th scope="col" class="px-6 py-3">
                email
              </th>
              <th scope="col" class="px-6 py-3">
                Documento
              </th>
              <th scope="col" class="px-6 py-3">
                Nro vivienda
              </th>
              <th scope="col" class="px-6 py-3">
                Creado
              </th>
              <th scope="col" class="px-6 py-3">
                Actualizado
              </th>
              <th scope="col" class="px-6 py-3">
                Accion
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="habitante in datas.list"
              :key="habitante.id"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ habitante.id }}
              </th>
              <td class="px-6 py-4">
                {{ habitante.perfil.name }}
              </td>
              <td class="px-6 py-4">
                {{ habitante.perfil.email }}
              </td>
              <td class="px-6 py-4">
                {{ habitante.perfil.nroDocumento }}
                <br />
                {{ habitante.detalle }}
              </td>
              <td class="px-6 py-4">
                Nro: {{ habitante.vivienda.nroVivienda }}
              </td>
              <td class="px-6 py-4">
                {{
                  habitante.created_at != null
                    ? fecha(habitante.created_at)
                    : ''
                }}
              </td>
              <td class="px-6 py-4">
                {{
                  habitante.updated_at != null
                    ? fecha(habitante.updated_at)
                    : ''
                }}
              </td>
              <td class="px-6 py-4">
                <Link
                  :href="route('tipodocumento.edit', habitante.id)"
                  class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                >
                  Editar
                </Link>
                <!-- <button
                  type="submit"
                  class="font-medium text-red-600 dark:text-red-500 hover:underline"
                >
                  Delete
                </button> -->
                <form @submit.prevent="destroyData(habitante.id)">
                  <!-- <input type="hidden" name="_method" value="DELETE" /> -->
                  <button
                    type="submit"
                    class="font-medium text-red-600 dark:text-red-500 hover:underline"
                  >
                    Eliminar
                  </button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- CUANDO LA LISTA ESTA VACIA -->
    <div
      v-else
      class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
      role="alert"
    >
      <svg
        class="flex-shrink-0 inline w-4 h-4 me-3"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 20 20"
      >
        <path
          d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
        />
      </svg>
      <span class="sr-only">Info</span>
      <div>
        <span class="font-medium">INFORMACION!</span>
        LISTA DE RESIDENTES VACIOS...
      </div>
    </div>
  </div>
</template>
