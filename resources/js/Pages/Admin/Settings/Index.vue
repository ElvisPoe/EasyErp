<template>
  <div>
    <Head title="Edit Settings" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        Edit Settings
      </h1>
    </div>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.organization_name" :error="form.errors.organization_name" class="pb-8 pr-6 w-full" label="Organization" />

          <text-input v-model="form.organization_name" :error="form.errors.organization_name" class="pb-8 pr-6 w-full" label="WooCommerce URL" />
          <text-input v-model="form.organization_name" :error="form.errors.organization_name" class="pb-8 pr-6 w-full lg:w-1/2" label="WooCommerce Key" />
          <text-input v-model="form.organization_name" :error="form.errors.organization_name" class="pb-8 pr-6 w-full lg:w-1/2" label="WooCommerce Secret" />

          <text-input v-model="form.organization_name" :error="form.errors.organization_name" class="pb-8 pr-6 w-full" label="Magento URL" />
          <text-input v-model="form.organization_name" :error="form.errors.organization_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Magento Key" />
          <text-input v-model="form.organization_name" :error="form.errors.organization_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Magento Secret" />

        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Settings</loading-button>
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
    setting: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        // first_name: this.setting.first_name,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/settings/${this.setting.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
  },
}
</script>
