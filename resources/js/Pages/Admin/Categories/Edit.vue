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
    <trashed-message v-if="category.deleted_at" class="mb-6" @restore="restore">This category has been deleted.</trashed-message>
    <div class="flex">
      <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="update">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
            <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description" />
            <select-input v-model="form.parent_category" :error="form.errors.parent_category" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent Category">
              <option value="">Select Category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
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
      <div class="ml-4 max-w-3xl bg-white rounded-md shadow overflow-hidden"
           style="width: 100%; display: flex; flex-direction: column; justify-content: space-between;">
        <table class="w-full whitespace-nowrap">
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Title</th>
            <th class="pb-4 pt-6 px-6">Published</th>
          </tr>
          <tr v-for="childCategory in childrenCategories" :key="childCategory.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/categories/${childCategory.id}/edit`">
                {{ childCategory.title }}
                <icon v-if="childCategory.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/categories/${childCategory.id}/edit`">
                {{ childCategory.published ? 'Yes' : 'No' }}
              </Link>
            </td>
          </tr>
          <tr v-if="childrenCategories.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No categories found.</td>
          </tr>
        </table>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <Link :href="`/admin/categories/create?parentCategory=${category.id}`" class="btn-indigo ml-auto">Create Child Category</Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Admin from '@/Layouts/Admin'

export default {
  layout: Admin,
  props: {
    category: Object,
    categories: Object,
    childrenCategories: Object
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
