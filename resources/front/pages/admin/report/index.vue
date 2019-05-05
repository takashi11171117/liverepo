<template>
    <section class="container">
        <AdminReportIndexHead />
        <AdminReportIndexTable />
    </section>
</template>

<script>
  import AdminReportIndexHead from '../../../components/admin/AdminReportIndexHead'
  import AdminReportIndexTable from '../../../components/admin/AdminReportIndexTable'

  export default {
    middleware: 'auth',

    layout: 'admin',

    watchQuery: ['page', 'per_page', 's'],

    components: {
      AdminReportIndexTable,
      AdminReportIndexHead
    },

    async asyncData({store, query, redirect}) {
      await store.dispatch('admin-report-index/fetchReportPagination', query);
    },
  }
</script>