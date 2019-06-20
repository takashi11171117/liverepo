<template>
    <section></section>
</template>

<script>
  import { mapActions } from 'vuex';

  export default {
    layout: 'admin',

    mounted () {
        this.logout();
    },

    methods: {
      ...mapActions(['logout'])
    }
  }
</script>