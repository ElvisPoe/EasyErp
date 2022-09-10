<template>
  <div>
    <Head :title="form.title" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/categories">Categories</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.title }}
      </h1>
    </div>
    <trashed-message v-if="category.deleted_at" class="mb-6" @restore="restore"> This category has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description" />
          <select-input v-model="form.parent_category" :error="form.errors.parent_category" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent Category">
            <option :value="0">Cat 1</option>
            <option :value="1">Cat 2</option>
          </select-input>
          <select-input v-model="form.published" :error="form.errors.published" class="pb-8 pr-6 w-full lg:w-1/2" label="Published">
            <option :value="0">False</option>
            <option :value="1">True</option>
          </select-input>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!category.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Category</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Category</loading-button>
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
    category: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        title: this.category.title,
        description: this.category.description,
        parent_category: this.category.parent_category,
        published: this.category.published,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/categories/${this.category.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this category?')) {
        this.$inertia.delete(`/admin/categories/${this.category.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this category?')) {
        this.$inertia.put(`/admin/categories/${this.category.id}/restore`)
      }
    },
  },
}
</script>
