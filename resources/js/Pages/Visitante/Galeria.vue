<script setup>
import { ref, inject, reactive, onMounted, computed } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import Loader from '@/Componentes/Loader.vue'
import SectionBorder from '@/Components/SectionBorder.vue'

import moment from 'moment'

const Swal = inject('$swal')

const props = defineProps({
  model: Object,
})

onMounted(() => {
  queryList(props.model.id)
})

const form = useForm({
  id: props.model != null ? props.model.id : '',
  image: null,
})

const reactives = reactive({
  isLoad: false,
  list: [],
  query: '',
})

const photoPreview = ref(null)
const photoInput = ref(null)
const image = ref(null)

const changeLoad = (value) => {
  reactives.isLoad = value
}

const sendModel = async () => {
  if (
    reactives.nameError.length != 0 ||
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
  const url = route('visitante.store', form)
  await axios
    .post(url)
    .then((response) => {
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
      }
    })
}

const updateInformation = async () => {
  console.log(form)
  const url = route('visitante.updateWeb', form.id)
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
      }
    })
}

const queryList = async (id) => {
  changeLoad(true)
  const url = route('galeriavisitante.getGaleriaVisitante', {
    visitante_id: id,
  })
  await axios
    .post(url)
    .then((response) => {
      console.log(response.data)
      if (response.data.success) {
        reactives.list = response.data.data
      }
    })
    .catch((error) => {
      console.log('respuesta error')
      console.log(error)
    })
  changeLoad(false)
}

const updatePhotoPreview = () => {
  const photo = photoInput.value.files[0]

  if (!photo) return

  const reader = new FileReader()

  reader.onload = (e) => {
    photoPreview.value = e.target.result
  }

  reader.readAsDataURL(photo)
}

const cargarImagenes = async () => {
  try {
    console.log(image)
    console.log(image.value)
    if (image) {
      let formData = new FormData()
      formData.append('id', props.model.id)
      formData.append('file', image.value)
      // formData.append('imageValue', image.value)
      /*const url = route('galeriavisitante.uploadimage', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })*/
      const response = await axios.post(
        '/galeriavisitante/uploadimage',
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        },
      )
      if (response.data.success) {
        queryList(props.model.id)
      }
      console.log(response.data)
    }
  } catch (error) {
    console.error(error)
  }
}

const onFileChange = (event) => {
  image.value = event.target.files[0]
}

const selectNewPhoto = () => {
  photoInput.value.click()

  console.log(photoInput)
  console.log(photoInput.value)
}

const deletePhoto = () => {
  router.delete(route('current-user-photo.destroy'), {
    preserveScroll: true,
    onSuccess: () => {
      photoPreview.value = null
      clearPhotoFileInput()
    },
  })
}

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null
  }
}

const fecha = (fechaData) => {
  return moment(fechaData).format('YYYY-MM-DD HH:MM:SS')
}
</script>

<template>
  <div v-if="reactives.isLoad" class="w-full p-6">
    <Loader />
  </div>
  <div v-else>
    <div class="col-span-12 sm:col-span-12 my-6">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        GALERIA DE VISITANTE
      </h2>
      <!-- Profile Photo File Input -->
      <!-- New Profile Photo Preview -->
      <div v-show="photoPreview" class="my-6">
        <span
          class="block rounded-lg max-w-auto h-96 bg-contain bg-no-repeat bg-center border border-gray-300"
          :style="'background-image: url(\'' + photoPreview + '\');'"
        />
      </div>
    </div>
    <div>
      <input type="file" @change="onFileChange" />
      <button
        @click="cargarImagenes"
        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center"
      >
        Subir Imagen
      </button>
    </div>
    <SectionBorder />
    <div v-if="reactives.list.length > 0" class="grid grid-cols-2 gap-2">
      <div v-for="item in reactives.list" :key="item.id">
        <img
          class="h-auto max-w-full rounded-lg"
          :src="item.photo_path"
          alt="No Encontrado"
        />
      </div>
    </div>

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
        <p>LISTADO VACIA...</p>
        <p v-if="reactives.query.length != 0">
          Consulta con:
          <span class="font-semibold text-blue-800 leading-tight">
            {{ reactives.query.toUpperCase() }}
          </span>
          no encontrada
        </p>
      </div>
    </div>
  </div>
</template>
