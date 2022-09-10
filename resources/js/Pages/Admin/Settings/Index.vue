<template>
  <div>
    <Head title="Settings" />
    <h1 class="mb-8 text-3xl font-bold">Settings</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Type:</label>
        <select v-model="form" class="form-select mt-1 w-full">
          <option :value="null" />
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/admin/settings/create">
        <span>Save</span>
        <span class="hidden md:inline">&nbsp;Settings</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Title</th>
          <th class="pb-4 pt-6 px-6">Sku</th>
          <th class="pb-4 pt-6 px-6">Barcode</th>
        </tr>

      </table>
    </div>
  </div>

</template>

<script>
import pickBy from 'lodash/pickBy'
import Admin from '@/Layouts/Admin'
import debounce from "lodash/debounce"
import mapValues from 'lodash/mapValues'

export default {
  layout: Admin,
  props: {
    settings: Object,
  },
  watch: {
    form: {
      deep: true,
      handler: debounce(function () {
        this.$inertia.get('/admin/settingss', pickBy(this.form), { preserveState: true })
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
