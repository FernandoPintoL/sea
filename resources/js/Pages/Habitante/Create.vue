<script setup>
import { ref, inject, reactive, onMounted } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ActionMessage from '@/Components/ActionMessage.vue'
import FormSection from '@/Components/FormSection.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

const swal = inject('$swal')

onMounted(() => {
  queryDocument('')
  queryHabitante('')
})

const form = useForm({
  name: '',
  email: '',
  direccion: '',
  celular: '',
  nroDocumento: '',
  tipo_documento_id: 0,
  /* datos de habitante */
  isDuenho: true,
  isDependiente: false,
  responsable_id: 0,
})

const react = reactive({
  isLoad: false,
  list_typedocument: [],
  list_habitante: [],
})

const createInformacion = async () => {
  form.isDependiente = !form.isDuenho
  const url = route('habitante.store', form)
  await axios
    .post(url)
    .then((response) => {
      console.log(response.data)
      swal.fire({
        title: response.data.success ? 'Buen Trabajo!' : 'Error!',
        text: response.data.success
          ? 'Dato creado exitosamente'
          : 'Algún error inesperado',
        icon: response.data.success ? 'success' : 'error',
      })
    })
    .catch((error) => {
      console.log(error.response)
      if (error.response.data.messageError) {
        console.log(error.response.data.message)
        swal.fire({
          title: error.response.data.messageError
            ? 'Error desde el micro servicio!'
            : 'Algun otro error esta sucediendo!',
          text: error.response.data.messageError
            ? 'Algunos datos fueron mal registrados'
            : 'Algun otro tipo de error sucedio',
          icon: error.response.data.messageError ? 'error' : 'success',
        })
      }
    })
}

const queryDocument = async (consulta) => {
  react.isLoad = true
  const url = route('tipodocumento.query', { query: consulta })
  await axios
    .post(url)
    .then((response) => {
      react.list_typedocument = response.data
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  react.isLoad = false
}

const queryHabitante = async (consulta) => {
  react.isLoad = true
  const url = route('habitante.query', { query: consulta })
  await axios
    .post(url)
    .then((response) => {
      react.list_habitante = response.data
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  react.isLoad = false
}
</script>

<template>
  <AppLayout title="TipoDocumento">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        CREAR HABITANTE O HUESPED
      </h2>
    </template>
    <div class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8">
      <FormSection @submitted="createInformacion">
        <template #title>
          Registro del Habitante
        </template>

        <template #description>
          Complete correctamente los datos personales
        </template>

        <template #form>
          <!-- Name -->
          <div class="col-span-12 sm:col-span-12">
            <label
              for="name"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Nombre
            </label>
            <div class="flex">
              <span
                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
              >
                <svg
                  class="w-4 h-4 text-gray-500 dark:text-gray-400"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"
                  />
                </svg>
              </span>
              <input
                v-model="form.name"
                type="text"
                id="name"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Bonnie Green"
              />
            </div>
          </div>
          <!-- Email -->
          <div class="col-span-12 sm:col-span-12">
            <label
              for="email"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Email
            </label>
            <div class="flex">
              <span
                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
              >
                <i class="fa-sharp fa-light fa-at"></i>
              </span>
              <input
                v-model="form.email"
                type="email"
                id="email"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="pintolinofernando@gmail.com"
              />
            </div>
          </div>
          <!-- Direccion -->
          <div class="col-span-12 sm:col-span-12">
            <label
              for="direccion"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Direccion
            </label>
            <div class="flex">
              <span
                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
              >
                <i class="fa-regular fa-map-location"></i>
              </span>
              <input
                v-model="form.direccion"
                type="text"
                id="direccion"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Bonnie Green"
              />
            </div>
          </div>
          <!-- Celular -->
          <div class="col-span-12 sm:col-span-12">
            <label
              for="celular"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Celular
            </label>
            <div class="flex">
              <span
                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
              >
                <i class="fa-solid fa-mobile"></i>
              </span>
              <input
                v-model="form.celular"
                type="tel"
                id="celular"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="+59173682145"
              />
            </div>
          </div>
          <div class="col-span-12 sm:col-span-12">
            <label
              for="countries"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Seleccione un tipo de documento
            </label>
            <select
              id="countries"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              v-model="form.tipo_documento_id"
            >
              <option selected :value="0">Seleccione un documento</option>
              <option
                v-for="type in react.list_typedocument"
                :key="type.id"
                :value="type.id"
              >
                {{ type.id }} : {{ type.sigla }} : {{ type.detalle }}
              </option>
            </select>
          </div>

          <!-- NRO DOCUMENTO -->
          <div class="col-span-12 sm:col-span-12">
            <label
              for="nroDocumento"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Numero de Documentacion
            </label>
            <div class="flex">
              <span
                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600"
              >
                <i class="fa-solid fa-id-card"></i>
              </span>
              <input
                v-model="form.nroDocumento"
                type="number"
                id="nroDocumento"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="8887777"
              />
            </div>
          </div>
          <!-- Es dueño -->
          <div class="col-span-12 sm:col-span-12">
            <label class="inline-flex items-center mb-5 cursor-pointer">
              <input
                type="checkbox"
                v-model="form.isDuenho"
                :value="form.isDuenho"
                class="sr-only peer"
              />
              <div
                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
              ></div>
              <span
                class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
              >
                Es dueño o propietario?
              </span>
            </label>
          </div>
          <!-- Responsable a cargo si no es dueño -->
          <div v-if="!form.isDuenho" class="col-span-12 sm:col-span-12">
            <label
              for="nroDocumento"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Asignarle un responsable
            </label>
            <div class="flex">
              <label
                for="search-dropdown"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
              >
                Asignarle un responsable dueño o propietario de vivienda
              </label>
              <button
                id="dropdown-button"
                data-dropdown-toggle="dropdown"
                class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                type="button"
              >
                Selecciona un Responsable
                <svg
                  class="w-2.5 h-2.5 ms-2.5"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 10 6"
                >
                  <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4"
                  />
                </svg>
              </button>
              <!-- LISTADO DE HABITANTES -->
              <div
                id="dropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
              >
                <ul
                  class="py-2 text-sm text-gray-700 dark:text-gray-200"
                  aria-labelledby="dropdown-button"
                >
                  <li v-for="hab in react.list_habitante" :key="hab.id">
                    <button
                      @click="form.responsable_id = hab.id"
                      type="button"
                      class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    >
                      {{ hab.name }}
                    </button>
                  </li>
                </ul>
              </div>
              <!-- INPUT DE BUSQUEDA -->
              <div class="relative w-full">
                <input
                  type="search"
                  id="search-dropdown"
                  class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                  placeholder="Consulta habitantes previamente registrados"
                  required
                />
                <button
                  type="submit"
                  class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 20"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                    />
                  </svg>
                  <span class="sr-only">Busqueda</span>
                </button>
              </div>
            </div>
          </div>
        </template>

        <template #actions>
          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Guardar
          </PrimaryButton>
        </template>
      </FormSection>
    </div>
  </AppLayout>
</template>
