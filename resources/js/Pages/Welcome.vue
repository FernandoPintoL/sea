<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import Checkbox from '@/Components/Checkbox.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

defineProps({
  canResetPassword: Boolean,
  status: String,
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form
    .transform((data) => ({
      ...data,
      remember: form.remember ? 'on' : '',
    }))
    .post(route('login'), {
      onFinish: () => form.reset('password'),
    })
}
</script>

<template>
  <Head title="Iniciar Sessión" />
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div
          class="login100-form-title"
          style="background-image: url(assets/images/bg-01.jpg);"
        >
          <span class="login100-form-title-1">
            Inicia Sessión
          </span>
        </div>

        <form class="login100-form validate-form" @submit.prevent="submit">
          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
          </div>
          <div
            class="wrap-input100 validate-input m-b-26"
            data-validate="Username is required"
          >
            <!-- <InputLabel class="label-input100">Username o Email</InputLabel> -->
            <InputLabel
              for="email"
              value="Usernick o Email"
              class="label-input100"
            />
            <TextInput
              id="email"
              v-model="form.email"
              type="text"
              class="mt-1 block w-full"
              required
              autofocus
              autocomplete="email"
            />
            <span class="focus-input100"></span>
            <InputError class="mt-2" :message="form.errors.email" />
          </div>
          <div
            class="wrap-input100 validate-input m-b-18"
            data-validate="Password is required"
          >
            <!-- <span class="label-input100">Password</span> -->
            <InputLabel
              for="password"
              value="Password"
              class="label-input100"
            />
            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              class="mt-1 block w-full"
              required
              autocomplete="current-password"
            />
            <span class="focus-input100"></span>
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <!-- <div class="flex-sb-m w-full p-b-30">
            <div class="contact100-form-checkbox">
              <label class="flex items-center">
                <Checkbox v-model:checked="form.remember" name="remember" />
                <span class="ms-2 text-sm text-gray-600">Recuerdame</span>
              </label>
            </div>

            <div>
              <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Olvdidaste tu contraseña?
              </Link>
            </div>
          </div> -->

          <div class="container-login100-form-btn">
            <div class="flex items-center justify-end mt-4">
              <PrimaryButton
                class="ms-4 login100-form-btn"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Iniciar
              </PrimaryButton>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style>
.backimage {
  background-image: url('~@/assets/images/bg-01.jpg');
}
</style>
