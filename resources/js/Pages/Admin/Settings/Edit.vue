<template>
  <div>
    <Head :title="form.title" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/admin/settings">Settings</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.title }}
      </h1>
    </div>
    <trashed-message v-if="setting.deleted_at" class="mb-6" @restore="restore"> This setting has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">

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
        first_name: this.user.first_name,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/admin/settings/${this.setting.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this setting?')) {
        this.$inertia.delete(`/admin/settings/${this.setting.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this setting?')) {
        this.$inertia.put(`/admin/settings/${this.setting.id}/restore`)
      }
    },
  },
}
</script>
