<script setup>
import { ref, inject, reactive, onMounted, computed } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import FormSection from '@/Components/FormSection.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputError from '@/Components/InputError.vue'
import ActionMessage from '@/Components/ActionMessage.vue'
import InputLabel from '@/Components/InputLabel.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import moment from 'moment'
import Select2 from 'vue3-select2-component'

const Swal = inject('$swal')

const props = defineProps({
  model: Object,
})

onMounted(() => {
  queryDocument('')
  queryHabitante('')
  queryVivienda('')
})

const form = useForm({
  id: props.model != null ? props.model.id : '',
  /*DATOS DEL PERFIL*/
  perfil: {
    name: props.model != null ? props.model.perfil.name : '',
    email: props.model != null ? props.model.perfil.email : '',
    celular: props.model != null ? props.model.perfil.celular : '',
    nroDocumento: props.model != null ? props.model.perfil.nroDocumento : '',
    tipo_documento_id:
      props.model != null ? props.model.perfil.tipo_documento_id : 1,
  },
  /* datos de habitante */
  isDuenho: props.model != null ? props.model.isDuenho : true,
  isDependiente: props.model != null ? props.model.isDependiente : false,
  responsable_id: props.model != null ? props.model.responsable_id : 0,
  perfil_id: props.model != null ? props.model.perfil_id : 0,
  vivienda_id: props.model != null ? props.model.vivienda_id : 0,
  isMobile: true,
})

const reactives = reactive({
  isLoad: false,
  list_typedocument: [],
  list_habitante: [],
  list_vivienda: [],
  nameError: '',
  celularError: '',
  nroDocumentoError: '',
  emailError: '',
})

const changeLoad = (value) => {
  reactives.isLoad = value
}

const onValidateName = (e) => {
  if (!/^[A-Za-z\s]{5,}$/.test(e.target.value)) {
    reactives.nameError =
      'El campo debe tener al menos 5 caracteres y solo pueden ser letras.'
  } else {
    reactives.nameError = ''
  }
}

const onValidateCelular = (e) => {
  if (!/^(?:[678]\d{7})?$/.test(e.target.value)) {
    reactives.celularError = 'Número de celular incorrecto'
  } else {
    reactives.celularError = ''
  }
}

const onValidateNroDocumento = (e) => {
  if (!/^\d+(-[a-zA-Z]{2,3})?$/.test(e.target.value)) {
    reactives.nroDocumentoError =
      'El campo debe tener solo numeros, puede contener 1 solo (-) y umn minimo de 2 letras.'
  } else {
    reactives.nroDocumentoError = ''
  }
}

const setErrorEmail = (value) => {
  console.log(value[0])
  reactives.emailError = value[0]
}

const setErrorNroDocumento = (value) => {
  console.log(value[0])
  reactives.nroDocumentoError = value[0]
}

const sendModel = async () => {
  if (
    reactives.nameError.length != 0 ||
    reactives.emailError.length != 0 ||
    reactives.celularError.length != 0 ||
    reactives.nroDocumentoError.length != 0
  ) {
    Swal.fire({
      position: 'top-end',
      icon: 'error',
      title: 'Validaciones sin corregir',
      showConfirmButton: false,
      timer: 1500,
    })
    return
  }
  if (form.isDuenho) {
    form.responsable_id = 0
  }
  Swal.fire({
    title: 'Estas seguro de registrar esta información?',
    text: '',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, estoy seguro!',
  }).then((result) => {
    if (result.isConfirmed) {
      if (props.model != null) {
        updateInformation()
      } else {
        createInformacion()
      }
    }
  })
}

const createInformacion = async () => {
  console.log(form)
  form.isDependiente = !form.isDuenho
  const url = route('habitante.store', form)
  await axios
    .post(url)
    .then((response) => {
      console.log(response)
      Swal.fire({
        position: 'top-end',
        icon: response.data.success ? 'success' : 'error',
        title: response.data.message,
        showConfirmButton: false,
        timer: 1500,
      })
      if (response.data.success) {
        form.reset()
      }
    })
    .catch((error) => {
      Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Verifique el formulario',
        showConfirmButton: false,
        timer: 1500,
      })
      if (error.response.data.messageError) {
        if (error.response.data.message.nroDocumento != null) {
          setErrorNroDocumento(error.response.data.message.nroDocumento)
        } else {
          setErrorNroDocumento('')
        }
        if (error.response.data.message.email != null) {
          setErrorEmail(error.response.data.message.email)
        } else {
          setErrorEmail('')
        }
      }
    })
}

const updateInformation = async () => {
  form.isDependiente = !form.isDuenho
  const url = route('habitante.update', form.id)
  await axios
    .put(url, form)
    .then((response) => {
      Swal.fire({
        position: 'top-end',
        icon: response.data.success ? 'success' : 'error',
        title: response.data.message,
        showConfirmButton: false,
        timer: 1500,
      })
    })
    .catch((error) => {
      Swal.fire({
        position: 'top-end',
        icon: 'error',
        title: 'Verifique el formulario',
        showConfirmButton: false,
        timer: 1500,
      })
      if (error.response.data.messageError) {
        if (error.response.data.message.nroDocumento != null) {
          setErrorNroDocumento(error.response.data.message.nroDocumento)
        } else {
          setErrorNroDocumento('')
        }
        if (error.response.data.message.email != null) {
          setErrorEmail(error.response.data.message.email)
        } else {
          setErrorEmail('')
        }
      }
    })
}

const queryDocument = async (consulta) => {
  changeLoad(true)
  const url = route('tipodocumento.query', { query: consulta })
  await axios
    .post(url)
    .then((response) => {
      if (response.data.success) {
        reactives.list_typedocument = response.data.data
        if (reactives.list_typedocument.length > 0) {
          if (props.model != null) {
            form.perfil.tipo_documento_id = props.model.perfil.tipo_documento_id
          } else {
            form.perfil.tipo_documento_id = reactives.list_typedocument[0].id
          }
        }
      }
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  changeLoad(false)
}
/// LISTAR LOS HABITANTES QUE SON DUEÑOS
const queryHabitante = async (consulta) => {
  changeLoad(true)
  const url = route('habitante.query', { query: consulta })
  await axios
    .post(url)
    .then((response) => {
      console.log(response)
      if (response.data.success) {
        reactives.list_habitante = response.data.data
        if (reactives.list_habitante.length > 0) {
          if (props.model != null) {
            form.responsable_id = props.model.responsable_id
          } else {
            form.responsable_id = reactives.list_habitante[0].id
          }
        }
      }
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  changeLoad(false)
}

const queryVivienda = async (consulta) => {
  changeLoad(true)
  const url = route('vivienda.query', { query: consulta })
  await axios
    .post(url)
    .then((response) => {
      if (response.data.success) {
        reactives.list_vivienda = response.data.data
        if (reactives.list_vivienda.length > 0) {
          if (props.model != null) {
            form.vivienda_id = props.model.vivienda_id
          } else {
            form.vivienda_id = reactives.list_vivienda[0].id
          }
        }
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
</script>

<template>
  <AppLayout title="RESIDENTE">
    <template #header>
      <h2
        v-if="props.model != null"
        class="font-semibold text-xl text-gray-800 leading-tight"
      >
        ACTUALIZAR RESIDENTE O HUESPED
      </h2>
      <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">
        CREAR RESIDENTE O HUESPED
      </h2>
    </template>
    <div v-if="reactives.isLoad" class="w-full p-6">
      <div class="text-center">
        <div role="status">
          <svg
            aria-hidden="true"
            class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
            viewBox="0 0 100 101"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
              fill="currentColor"
            />
            <path
              d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
              fill="currentFill"
            />
          </svg>
          <span class="sr-only">Cargando Formulario...</span>
          <div class="mb-1 text-base font-medium dark:text-white">
            Cargando Formulario...
          </div>
        </div>
      </div>
    </div>
    <div v-else class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8">
      <FormSection @submitted="sendModel">
        <template #title>
          <p v-if="props.model != null">
            Actualizar Residente COD #{{ props.model.id }}
          </p>
          <p v-else>Registro del Residente</p>
        </template>

        <template #description>
          <p v-if="props.model != null">
            <span class="font-semibold text-gray-800 leading-tight">
              Creado:
            </span>
            {{ fecha(props.model.created_at) }}
          </p>
          <p v-if="props.model != null">
            <span class="font-semibold text-gray-800 leading-tight">
              Actualizado:
            </span>
            {{ fecha(props.model.updated_at) }}
          </p>
          <p>
            Complete correctamente los datos personales
          </p>
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
                v-model="form.perfil.name"
                @input="onValidateName"
                required
                type="text"
                id="name"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Bonnie Green"
              />
            </div>
            <InputError class="mt-2" :message="reactives.nameError" />
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
                <i class="fa-solid fa-at"></i>
              </span>
              <input
                v-model="form.perfil.email"
                type="email"
                id="email"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="pintolinofernando@gmail.com"
              />
            </div>
            <InputError class="mt-2" :message="reactives.emailError" />
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
                <i class="fa-solid fa-square-phone"></i>
              </span>
              <input
                v-model="form.perfil.celular"
                @input="onValidateCelular"
                type="tel"
                id="celular"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="+59173682145"
              />
            </div>
            <InputError class="mt-2" :message="reactives.celularError" />
          </div>
          <!-- TIPO DE DOCUMENTO -->
          <div class="col-span-12 sm:col-span-12">
            <label
              for="tipo-doc"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
              Seleccione un tipo de documento
            </label>

            <select
              id="tipo-doc"
              class="custom bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              v-model="form.perfil.tipo_documento_id"
            >
              <option
                v-for="item in reactives.list_typedocument"
                :key="item.id"
                :value="item.id"
              >
                {{ item.id }} : {{ item.sigla }} : {{ item.detalle }}
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
                v-model="form.perfil.nroDocumento"
                @input="onValidateNroDocumento"
                type="text"
                id="nroDocumento"
                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="8887777-EXT"
              />
            </div>
            <InputError class="mt-2" :message="reactives.nroDocumentoError" />
          </div>
          <!-- Es dueño -->
          <div class="col-span-12 sm:col-span-12">
            <div class="flex items-center">
              <input
                type="checkbox"
                id="ingreso-is-duenho"
                class="relative shrink-0 w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-green-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-green-600 checked:border-green-600 focus:checked:border-green-600 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-green-500 dark:checked:border-green-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6 before:bg-white checked:before:bg-green-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-green-200"
                v-model="form.isDuenho"
              />
              <label
                for="ingreso-is-duenho"
                class="text-sm text-gray-500 ms-3 dark:text-neutral-400"
              >
                Es Dueño?
              </label>
            </div>
          </div>
          <!-- <p>{{ react.list_habitante }}</p> -->
          <!-- Responsable a cargo si no es dueño -->
          <div v-if="!form.isDuenho" class="col-span-12 sm:col-span-12">
            <label for="residentes" class="mb-2 text-sm font-medium">
              <i class="fa-solid fa-people-roof"></i>
              Seleccione un residente
            </label>
            <div class="flex justify-start">
              <select
                id="residentes"
                class="block w-full mt-3 col-span-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                v-model="form.responsable_id"
              >
                <option
                  class="w-full"
                  v-for="item in reactives.list_habitante"
                  :key="item.id"
                  :value="item.id"
                >
                  CI: {{ item.nroDocumento }} / Nombre:
                  {{ item.name }}
                </option>
              </select>
            </div>
          </div>

          <!-- NUMERO DE VIVIENDA -->
          <div class="col-span-12 sm:col-span-12">
            <label for="residentes" class="mb-2 text-sm font-medium">
              <i class="fa-solid fa-house"></i>
              Seleccione una vivienda
            </label>
            <select
              id="viviendas"
              class="custom col-span-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              v-model="form.vivienda_id"
            >
              <option
                v-for="item in reactives.list_vivienda"
                :key="item.id"
                :value="item.id"
              >
                ID: {{ item.id }} / Vivienda:
                {{ item.nroVivienda }}
              </option>
            </select>
          </div>
        </template>

        <template #actions>
          <PrimaryButton
            v-if="!reactives.isLoad"
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
<script>
$(document).ready(function () {
  // $('#select-residente').select2();
  $('select').select2()
  $('.custom').select2()
})
</script>
