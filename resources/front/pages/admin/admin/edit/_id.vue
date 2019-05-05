<template>
    <AdminEdit />
</template>

<script>
  import AdminEdit from '../../../../components/admin/AdminEdit'

  export default {
    middleware: 'auth',

    layout: 'admin',

    components: {
      AdminEdit,
    },

    async asyncData({store, params}) {
      await store.dispatch('admin-edit/fetchAdmin', {id: params.id});
    },
  }
</script>