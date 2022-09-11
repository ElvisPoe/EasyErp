<template>
  <div>
    <Head :title="form.title" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/products">Products</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.title }}
      </h1>
      <img v-if="product.photo" class="block ml-4 w-8 h-8 rounded-full" :src="product.photo" />
    </div>
    <trashed-message v-if="product.deleted_at" class="mb-6" @restore="restore"> This product has been deleted. </trashed-message>
    <div class="flex">
      <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
        <form @submit.prevent="update">
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
            <select-input v-if="!product.parent_product" v-model="form.has_variations" :error="form.errors.has_variations"
                          class="pb-8 pr-6 w-full lg:w-1/2" label="Variations">
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
                        class="pb-8 pr-6 w-full lg:w-1/2" label="Attribute label" />
            <text-input v-if="!form.has_variations" v-model="form.attribute_value" :error="form.errors.attribute_value"
                        class="pb-8 pr-6 w-full lg:w-1/2" label="Attribute value" />

          </div>
          <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
            <button v-if="!product.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Product</button>
            <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Product</loading-button>
          </div>
        </form>
      </div>
      <div v-if="form.has_variations" class="ml-4 max-w-3xl bg-white rounded-md shadow overflow-hidden w-full flex flex-col justify-between">
        <table class="w-full whitespace-nowrap">
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Sku</th>
            <th class="pb-4 pt-6 px-6">Barcode</th>
            <th class="pb-4 pt-6 px-6">Attribute</th>
            <th class="pb-4 pt-6 px-6">Value</th>
            <th class="pb-4 pt-6 px-6">Qty</th>
          </tr>
          <tr v-for="variation in variations" :key="variation.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/products/${variation.id}/edit`">
                {{ variation.sku }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/products/${variation.id}/edit`">
                {{ variation.barcode }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/products/${variation.id}/edit`">
                {{ variation.attribute_label }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/products/${variation.id}/edit`">
                {{ variation.attribute_value }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/admin/products/${variation.id}/edit`">
                {{ variation.quantity }}
              </Link>
            </td>
          </tr>
          <tr v-if="variations.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No variations found.</td>
          </tr>
        </table>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <Link :href="`/admin/products/create?parent_product=${product.id}`" class="btn-indigo ml-auto">Create variation</Link>
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
    categories: Object,
    product: Object,
    variations: Object
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        title: this.product.title,
        short_description: this.product.short_description,
        description: this.product.description,
        price: this.product.price,
        sale_price: this.product.sale_price,
        sku: this.product.sku,
        barcode: this.product.barcode,
        quantity: this.product.quantity,
        weight: this.product.weight,
        has_variations: this.product.has_variations,
        images: this.product.images,
        published: this.product.published,
        category_id: this.product.category_id,
        attribute_label: this.product.attribute_label,
        attribute_value: this.product.attribute_value,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/products/${this.product.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this product?')) {
        this.$inertia.delete(`/admin/products/${this.product.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this product?')) {
        this.$inertia.put(`/admin/products/${this.product.id}/restore`)
      }
    },
  },
}
</script>
