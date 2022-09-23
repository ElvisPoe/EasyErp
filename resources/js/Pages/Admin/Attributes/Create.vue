<template>
  <div>
    <Head title="Create Attribute" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/attributes">Attributes</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
          <select-input v-model="form.published" :error="form.errors.published" class="pb-8 pr-6 w-full lg:w-1/2" label="Published">
            <option :value="0">False</option>
            <option :value="1">True</option>
          </select-input>
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Attribute</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Admin from '@/Layouts/Admin'

export default {
  layout: Admin,
  props: {
    attributes: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: '',
        published: '',
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/admin/attributes')
    },
  },
}
</script>
