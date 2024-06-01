<script setup>
import { ref, inject, reactive } from 'vue'
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

const form = useForm({
  sigla: '',
  detalle: '',
})

const messages = reactive({
  eSigla: [],
  eDetalle: [],
})

const createInformacion = async () => {
  await axios
    .post('/tipodocumento', form)
    .then((response) => {
      console.log(response.data)
      swal.fire({
        title: response.data.success ? 'Buen Trabajo!' : 'Error!',
        text: response.data.success
          ? 'Dato creado exitosamente'
          : 'Algún error inesperado',
        icon: response.data.success ? 'success' : 'error',
      })
      messages.eDetalle = []
      messages.eSigla = []
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
        messages.eSigla =
          error.response.data.message.sigla != null
            ? error.response.data.message.sigla
            : []
        messages.eDetalle =
          error.response.data.message.detalle != null
            ? error.response.data.message.detalle
            : []
      }
    })
}
</script>

<template>
  <AppLayout title="TipoDocumento">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        CREA UN DOCUMENTO
      </h2>
    </template>
    <div class="max-w-7xl py-6 mx-auto sm:px-6 lg:px-8">
      <FormSection @submitted="createInformacion">
        <template #title>
          Documento de Identidad
        </template>

        <template #description>
          Identificacion de la persona
        </template>

        <template #form>
          <!-- Sigla -->
          <div class="col-span-12 sm:col-span-12">
            <InputLabel for="sigla" value="Sigla" />
            <TextInput
              id="sigla"
              v-model="form.sigla"
              type="text"
              class="mt-1 block w-full"
              required
              autocomplete="sigla"
            />
            <div v-if="messages.eSigla.length > 0">
              <div v-for="(msg, index) in messages.eSigla" :key="index">
                <InputError :message="msg.toUpperCase()" class="mt-2" />
              </div>
            </div>
          </div>
          <!-- Detalle -->
          <div class="col-span-12 sm:col-span-12">
            <InputLabel for="detalle" value="Detalle" />
            <TextInput
              id="detalle"
              v-model="form.detalle"
              type="text"
              class="mt-1 block w-full"
              required
              autocomplete="sigla"
            />
            <div v-if="messages.eDetalle.length > 0">
              <div v-for="(msg, index) in messages.eDetalle" :key="index">
                <InputError :message="msg.toUpperCase()" class="mt-2" />
              </div>
            </div>
          </div>
        </template>

        <template #actions>
          <ActionMessage :on="form.recentlySuccessful" class="me-3">
            Saved.
          </ActionMessage>

          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Save
          </PrimaryButton>
        </template>
      </FormSection>

      <!-- <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        @click="showAlert"
      >
        Alert
      </PrimaryButton> -->
    </div>
  </AppLayout>
</template>
