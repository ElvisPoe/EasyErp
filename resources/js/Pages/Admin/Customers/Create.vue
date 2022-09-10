<template>
  <div>
    <Head title="Create Customer" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/customers">Customers</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">

      </form>
    </div>
  </div>
</template>

<script>
import Admin from '@/Layouts/Admin'

export default {
  layout: Admin,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        first_name: '',
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/admin/customers')
    },
  },
}
</script>
