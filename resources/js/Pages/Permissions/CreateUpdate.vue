<script setup>
import { ref, inject, reactive, onMounted, computed } from 'vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import FormSection from '@/Components/FormSection.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputError from '@/Components/InputError.vue'
import Loader from '@/Componentes/Loader.vue'
import moment from 'moment-timezone'

const Swal = inject('$swal')

const props = defineProps({
    model: Object,
    crear: {
        type: Boolean,
        default: false, // Valor por defecto puede ser true o false
    },
    editar: {
        type: Boolean,
        default: false, // Valor por defecto puede ser true o false
    },
    eliminar: {
        type: Boolean,
        default: false, // Valor por defecto puede ser true o false
    },
})

onMounted(() => {
    // queryDocument('')
})

const form = useForm({
    id: props.model != null ? props.model.id : '',
    name: props.model != null ? props.model.name : '',
    guard_name: props.model != null ? props.model.guard_name : '',
})

const reactives = reactive({
    isLoad: false,
    isPassword: true,
    list_typedocument: [],
    nameError: '',
})

const sendModel = async () => {
    if (reactives.nameError.length != 0) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Validaciones sin corregir',
            showConfirmButton: false,
            timer: 1500,
        })
        return
    }

    /*if (form.razonSocial.length == 0) form.razonSocial = null
    if (form.nit == null || form.nit.length == 0) {
      form.nit = null
      form.perfil.nroDocumento = null
    }*/

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
            console.log(form)
            reactives.isLoad = true
            if (props.model != null) {
                updateInformation()
            } else {
                createInformacion()
            }
            reactives.isLoad = false
        }
    })
}

const onValidateName = (e) => {
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ. ]{2,}$/.test(e.target.value)) {
        reactives.nameError =
            'El campo debe tener al menos 2 caracteres y solo pueden ser letras.'
    } else {
        reactives.nameError = ''
        form.name = e.target.value.toUpperCase()
        form.guard_name = e.target.value.toUpperCase()
    }
}
const setErrorName = (value) => {
    console.log(value)
    reactives.nameError = value
}

const createInformacion = async () => {
    console.log(form)
    const url = route('permissions.store', form)
    await axios
        .post(url)
        .then((response) => {
            console.log(response.data)
            Swal.fire({
                position: 'top-end',
                icon: response.data.isSuccess ? 'success' : 'error',
                title: response.data.message,
                showConfirmButton: false,
                timer: 1500,
            })
            if (response.data.isSuccess) {
                form.reset()
            }
        })
        .catch((error) => {
            console.log(error)
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Verifique el formulario',
                showConfirmButton: false,
                timer: 1500,
            })
            if (error.response.data.isMessageError) {
                if (error.response.data.message.name != null) {
                    setErrorName(error.response.data.message.name[0])
                } else {
                    setErrorName('')
                }
            }
        })
}

const updateInformation = async () => {
    console.log(form)
    const url = route('permissions.update', form.id)
    await axios
        .put(url, form)
        .then((response) => {
            console.log(response)
            Swal.fire({
                position: 'top-end',
                icon: response.data.isSuccess ? 'success' : 'error',
                title: response.data.message,
                showConfirmButton: false,
                timer: 1500,
            })
        })
        .catch((error) => {
            console.log(error)
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Verifique el formulario',
                showConfirmButton: false,
                timer: 1500,
            })
            if (error.response.data.isMessageError) {
                if (error.response.data.message.name != null) {
                    setErrorName(error.response.data.message.name[0])
                } else {
                    setErrorName('')
                }
            }
        })
}

const fecha = (fechaData) => {
    return moment.tz(fechaData, 'America/La_Paz').format('YYYY-MM-DD HH:MM a')
}

const changeInputPassword = () => {
    reactives.isPassword = !reactives.isPassword
}
</script>

<template>
    <AppLayout title="ROLES">
        <div v-if="reactives.isLoad">
            <Loader />
        </div>
        <FormSection v-else @submitted="sendModel">
            <template #title>
                <p v-if="props.model != null">
                    Actualizar Permisos COD #{{ props.model.id }}
                </p>
                <p v-else>Registro del Permiso</p>
            </template>

            <template #description>
                <p v-if="props.model != null">
                    <span class="font-semibold text-gray-800 leading-tight">
                        Creado:
                    </span>
                    {{
                        props.model.created_at == null ? '' : fecha(props.model.created_at)
                    }}
                </p>
                <p v-if="props.model != null">
                    <span class="font-semibold text-gray-800 leading-tight">
                        Actualizado:
                    </span>
                    {{
                        props.model.updated_at == null ? '' : fecha(props.model.updated_at)
                    }}
                </p>
                <p>
                    Complete correctamente los datos personales
                </p>
            </template>

            <template #form>
                <!-- NOMBRE -->
                <div class="col-span-12 sm:col-span-12">
                    <label for="propietario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nombre(*)
                    </label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            <i class="fa-solid fa-person-chalkboard"></i>
                        </span>
                        <input v-model="form.name" @input="onValidateName" required type="text" id="name-users"
                            class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Bonnie Green" />
                    </div>
                    <InputError class="mt-2" :message="reactives.nameError" />
                </div>
            </template>

            <template #actions>
                <PrimaryButton v-if="props.editar || props.crear" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Guardar
                </PrimaryButton>
            </template>
        </FormSection>
    </AppLayout>
</template>
