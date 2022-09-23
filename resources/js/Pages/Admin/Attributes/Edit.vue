<template>
  <div>
    <Head :title="form.title" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/attributes">Attributes</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.title }}
      </h1>
    </div>
    <trashed-message v-if="attribute.deleted_at" class="mb-6" @restore="restore">This attribute has been deleted.</trashed-message>
    <div class="flex">
      <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="update">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
            <select-input v-model="form.published" :error="form.errors.published" class="pb-8 pr-6 w-full lg:w-1/2" label="Published">
              <option :value="0">False</option>
              <option :value="1">True</option>
            </select-input>
          </div>
          <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
            <button v-if="!attribute.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Attribute</button>
            <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Attribute</loading-button>
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
          <tr v-for="attributeValue in attributeValues" :key="attributeValue.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/attributeValue/${attributeValue.id}/edit`">
                {{ attributeValue.title }}
                <icon v-if="attributeValue.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/attributeValue/${attributeValue.id}/edit`">
                {{ attributeValue.published ? 'Yes' : 'No' }}
              </Link>
            </td>
          </tr>
          <tr v-if="attributeValues.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No values found.</td>
          </tr>
        </table>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <Link :href="`/admin/attributeValues/create?attributeValue=${attribute.id}`" class="btn-indigo ml-auto">Create Value</Link>
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
    attribute: Object,
    attributes: Object,
    attributeValues: Object
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        title: this.attribute.title,
        published: this.attribute.published,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/attributes/${this.attribute.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this attribute?')) {
        this.$inertia.delete(`/admin/attributes/${this.attribute.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this attribute?')) {
        this.$inertia.put(`/admin/attributes/${this.attribute.id}/restore`)
      }
    },
  },
}
</script>
