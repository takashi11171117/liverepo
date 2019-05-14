<template>
    <section class="container">
        <AdminIndexHead />
        <AdminIndexTable />
    </section>
</template>

<script>
  import AdminIndexHead from '../../components/admin/AdminIndexHead'
  import AdminIndexTable from '../../components/admin/AdminIndexTable'

  export default {
    middleware: 'auth',

    layout: 'admin',

    watchQuery: ['page', 'per_page', 's'],

    components: {
      AdminIndexTable,
      AdminIndexHead
    },

    async asyncData({store, query}) {
      await store.dispatch('admin-index/fetchAdminPagination', query);
    },
  }
</script>