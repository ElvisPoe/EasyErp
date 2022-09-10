<template>
  <Head title="Register" />
  <div class="flex items-center justify-center p-6 min-h-screen gradient">
    <div class="w-full max-w-md">
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold">Welcome!</h1>
          <div class="mt-6 mx-auto w-24 border-b-2" />
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="mt-6" label="First Name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="mt-6" label="Last Name" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-6" label="Email" type="email" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
          <text-input v-model="form.password_confirmation" :error="form.errors.password_confirmation" class="mt-6" label="Password again" type="password" />
          <label class="flex items-center mt-6 select-none" for="remember">
            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
            <span class="text-sm">Remember Me</span>
          </label>
        </div>
        <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100 items-center">
          <Link href="/login">Login here</Link>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Register</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      form: this.$inertia.form({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
        remember: false,
      }),
    }
  },
  methods: {
    login() {
      this.form.post('/register')
    },
  },
}
</script>


<style>
.gradient {
  background: linear-gradient(0, #d53369 0%, #daae51 100%);
}
</style>
