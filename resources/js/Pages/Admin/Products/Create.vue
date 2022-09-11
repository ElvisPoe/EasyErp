<template>
  <div>
    <Head title="Create User" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/products">Products</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.short_description" :error="form.errors.short_description" class="pb-8 pr-6 w-full lg:w-1/2" label="Short Description" />
          <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full" label="Description" />
          <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full lg:w-1/2" label="Price" />
          <text-input v-model="form.sale_price" :error="form.errors.sale_price" class="pb-8 pr-6 w-full lg:w-1/2" label="Sale Price" />
          <text-input v-model="form.sku" :error="form.errors.sku" class="pb-8 pr-6 w-full lg:w-1/2" label="Sku" />
          <text-input v-model="form.barcode" :error="form.errors.barcode" class="pb-8 pr-6 w-full lg:w-1/2" label="Barcode" />
          <text-input v-model="form.quantity" :error="form.errors.quantity" class="pb-8 pr-6 w-full lg:w-1/2" label="Quantity" />
          <text-input v-model="form.weight" :error="form.errors.weight" class="pb-8 pr-6 w-full lg:w-1/2" label="Weight" />
          <select-input v-model="form.has_variations" :error="form.errors.has_variations" class="pb-8 pr-6 w-full lg:w-1/2" label="Variations">
            <option :value="false">False</option>
            <option :value="true">True</option>
          </select-input>
          <select-input v-model="form.published" :error="form.errors.published" class="pb-8 pr-6 w-full lg:w-1/2" label="Published">
            <option :value="false">False</option>
            <option :value="true">True</option>
          </select-input>
          <select-input v-model="form.category_id" :error="form.errors.category_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Category">
            <option value="">Select Category</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
          </select-input>
          <file-input v-model="form.images" :error="form.errors.images" class="pb-8 pr-6 w-full" type="file" accept="image/*" label="Images" />

          <text-input v-if="!form.has_variations" v-model="form.attribute_label" :error="form.errors.attribute_label"
                      class="pb-8 pr-6 w-full lg:w-1/2" label="Attribute Label" />
          <text-input v-if="!form.has_variations" v-model="form.attribute_value" :error="form.errors.attribute_value"
                      class="pb-8 pr-6 w-full lg:w-1/2" label="Attribute Value" />

        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Product</loading-button>
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
    categories: Object,
    parent_product: String
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: '',
        short_description: '',
        description: '',
        price: '',
        sale_price: '',
        sku: '',
        barcode: '',
        quantity: '',
        weight: '',
        has_variations: false,
        images: '',
        published: false,
        category_id: '',
        parent_product: this.parent_product,
        attribute_label: '',
        attribute_value: '',
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/admin/products')
    },
  },
}
</script>
