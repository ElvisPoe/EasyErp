<template>
  <div>
    <Head title="Categories" />
    <h1 class="mb-8 text-3xl font-bold">Categories</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Type:</label>
        <select v-model="form.type" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="simple">Simple</option>
          <option value="configuration">Configurable</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/admin/categories/create">
        <span>Create Category</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Title</th>
          <th class="pb-4 pt-6 px-6">Is parent</th>
          <th class="pb-4 pt-6 px-6">Published</th>
        </tr>
        <tr v-for="category in categories.data" :key="category.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/categories/${category.id}/edit`">
              {{ category.title }}
              <icon v-if="category.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/admin/categories/${category.id}/edit`" tabindex="-1">
              {{ category.parent_category }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/admin/categories/${category.id}/edit`" tabindex="-1">
              {{ category.published }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/admin/categories/${category.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="categories.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No category found.</td>
        </tr>
      </table>
    </div>
  </div>

  <Paginator :links="categories.links" />

</template>

<script>
import pickBy from 'lodash/pickBy'
import Admin from '@/Layouts/Admin'
import debounce from "lodash/debounce"
import mapValues from 'lodash/mapValues'

export default {
  layout: Admin,
  props: {
    filters: Object,
    categories: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: debounce(function () {
        this.$inertia.get('/admin/categories', pickBy(this.form), { preserveState: true })
      }, 350),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
