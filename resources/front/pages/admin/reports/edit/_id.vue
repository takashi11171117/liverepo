<template>
    <ReportEdit :reportId="$route.params.id"/>
</template>

<script>
  import ReportEdit from "../../../../components/admin/ReportEdit";

  export default {
    middleware: [
      'redirectIfAdminGuest'
    ],

    layout: 'admin',

    components: {
      ReportEdit,
    },

    async asyncData({store, params}) {
      await store.dispatch('admin-report-edit/fetchEachData', {id: params.id});
    },
  }
</script>