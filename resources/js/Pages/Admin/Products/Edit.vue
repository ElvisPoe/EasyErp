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
          <text-input v-model="form.weight" :error="form.errors.weight" class="pb-8 pr-6 w-full lg:w-1/2" label="Weight" />
          <select-input v-model="form.has_variations" :error="form.errors.has_variations" class="pb-8 pr-6 w-full lg:w-1/2" label="Variations">
            <option :value="0">False</option>
            <option :value="1">True</option>
          </select-input>
          <select-input v-model="form.published" :error="form.errors.published" class="pb-8 pr-6 w-full lg:w-1/2" label="Published">
            <option :value="0">False</option>
            <option :value="1">True</option>
          </select-input>
          <select-input v-model="form.category_id" :error="form.errors.category_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Category">
            <option :value="1">Cat 1</option>
            <option :value="2">Cat 2</option>
          </select-input>
          <file-input v-model="form.images" :error="form.errors.images" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Images" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!product.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Product</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Product</loading-button>
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
    product: Object,
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
        weight: this.product.weight,
        has_variations: this.product.has_variations,
        images: this.product.images,
        published: this.product.published,
        category_id: this.product.category_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/products/${this.product.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
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
