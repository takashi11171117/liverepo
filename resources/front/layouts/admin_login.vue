<template>
    <div class="site">
        <nav-bar :show="true"/>
        <section>
            <nuxt class="has-text-centered is-fluid is-marginless app-content"/>
        </section>
     </div>
</template>
<script>
  import NavBar from '~/components/admin/NavBar.vue'

  export default {
    components: {
      NavBar,
    },
  }
</script>
<style lang="scss">
    @import "~bulma/bulma";
    @import '~bulma/sass/utilities/initial-variables';
    @import '~bulma/sass/utilities/derived-variables';
    @import '~bulma/sass/utilities/mixins';
    .animated {
        animation-duration: .377s;
    }
    html {
        background-color: whitesmoke;
    }
</style>