<template>
    <div class="site">
        <nav-bar :show="true"/>
        <sidebar :show="$store.getters.sidebar.opened && !$store.getters.sidebar.hidden"></sidebar>
        <section class="app-main">
            <nuxt class="has-text-left is-fluid is-marginless app-content"/>
        </section>
     </div>
</template>
<script>
  import NavBar from '~/components/admin/NavBar.vue'
  import Sidebar from '~/components/admin/Sidebar.vue'
  import { mapGetters, mapActions } from 'vuex'

  export default {
    components: {
      NavBar,
      Sidebar
    },
    beforeMount () {
      const { body } = document;
      const WIDTH = 768;
      const RATIO = 3;
      const handler = () => {
        if (!document.hidden) {
          let rect = body.getBoundingClientRect();
          let isMobile = rect.width - RATIO < WIDTH;
          this.toggleDevice(isMobile ? 'mobile' : 'other');
          this.toggleSidebar({
            opened: !isMobile
          })
        }
      };
      document.addEventListener('visibilitychange', handler);
      window.addEventListener('DOMContentLoaded', handler);
      window.addEventListener('resize', handler)
    },
    computed: mapGetters({
      sidebar: 'sidebar'
    }),
    methods: mapActions([
      'toggleDevice',
      'toggleSidebar'
    ])
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
    .app-main {
        padding-top: 52px;
        margin-left: 230px;
        transform: translate3d(0, 0, 0);
        @include mobile() {
            margin-left: 0;
        }
    }
    .app-content {
        padding: 20px;
    }
</style>