<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Admin from '@/Layouts/Admin'

export default {
  components: {
    Head,
  },
  layout: Admin,
}
</script>
