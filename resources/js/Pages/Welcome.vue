<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import Checkbox from '@/Components/Checkbox.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
/*import '/public/assets/vendor/animsition/js/animsition.min.js'
import '/public/assets/vendor/select2/select2.min.js'
import '/public/assets/vendor/daterangepicker/moment.min.js'
import '/public/assets/vendor/daterangepicker/daterangepicker.js'
import '/public/assets/vendor/bootstrap/js/popper.js'
import '/public/assets/vendor/bootstrap/js/bootstrap.min.js'
import '/public/assets/vendor/countdowntime/countdowntime.js'*/
// import '/public/assets/js/main.js'
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
  <!-- <div class="limiter">
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
  </div> -->
  <div class="font-[sans-serif]">
    <div
      class="min-h-screen flex fle-col items-center justify-center py-6 px-4"
    >
      <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
        <div
          class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto"
        >
          <form class="space-y-4" @submit.prevent="submit">
            <div class="mb-8">
              <h3 class="text-gray-800 text-3xl font-extrabold">
                Iniciar Session
              </h3>
              <p class="text-gray-500 text-sm mt-4 leading-relaxed"></p>
            </div>

            <div>
              <label class="text-gray-800 text-sm mb-2 block">Email</label>
              <div class="relative flex items-center">
                <input
                  v-model="form.email"
                  name="username"
                  type="text"
                  required
                  class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
                  placeholder="Ingresar Email"
                />
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="#bbb"
                  stroke="#bbb"
                  class="w-[18px] h-[18px] absolute right-4"
                  viewBox="0 0 24 24"
                >
                  <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                  <path
                    d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"
                    data-original="#000000"
                  ></path>
                </svg>
              </div>
              <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
              <label class="text-gray-800 text-sm mb-2 block">Password</label>
              <div class="relative flex items-center">
                <input
                  v-model="form.password"
                  name="password"
                  type="password"
                  required
                  class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
                  placeholder="Ingrese password"
                />
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="#bbb"
                  stroke="#bbb"
                  class="w-[18px] h-[18px] absolute right-4 cursor-pointer"
                  viewBox="0 0 128 128"
                >
                  <path
                    d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"
                    data-original="#000000"
                  ></path>
                </svg>
              </div>
              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- <div class="flex flex-wrap items-center justify-between gap-4">
              <div class="flex items-center">
                <input
                  id="remember-me"
                  name="remember-me"
                  type="checkbox"
                  class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label
                  for="remember-me"
                  class="ml-3 block text-sm text-gray-800"
                >
                  Remember me
                </label>
              </div>

              <div class="text-sm">
                <a
                  href="jajvascript:void(0);"
                  class="text-blue-600 hover:underline font-semibold"
                >
                  Forgot your password?
                </a>
              </div>
            </div> -->

            <div class="!mt-8">
              <button
                type="submit"
                class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none"
              >
                Iniciar Session
              </button>
            </div>

            <!-- <p class="text-sm !mt-8 text-center text-gray-800">
              Don't have an account
              <a
                href="javascript:void(0);"
                class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap"
              >
                Register here
              </a>
            </p> -->
          </form>
        </div>
        <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
          <img
            src="/assets/images/sealog.jpeg"
            class="w-full h-full max-md:w-4/5 mx-auto block object-cover"
            alt="Dining Experience"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/*@import '/public/assets/css/util.css';
@import '/public/assets/css/main.css';*/

.backimage {
  background-image: url('~@/assets/images/bg-01.jpg');
}
</style>
