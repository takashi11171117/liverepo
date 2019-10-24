<template>
  <div class="site">
    <NavBar :show="true" />
    <Sidebar :show="sidebar.opened && !sidebar.hidden" />
    <section class="app-main">
      <nuxt class="has-text-left is-fluid is-marginless app-content" />
    </section>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { AdminSidebarStore } from '@/store'
import NavBar from '@/layouts/parcial/admin/NavBar.vue'
import Sidebar from '@/layouts/parcial/admin/Sidebar.vue'

@Component({
  components: {
    NavBar,
    Sidebar
  }
})
export default class AdminIndex extends Vue {
  get sidebar () {
    return AdminSidebarStore.getSidebar
  }

  beforeMount () {
    const { body } = document
    const WIDTH = 768
    const RATIO = 3
    const handler = () => {
      if (!document.hidden) {
        const rect = body.getBoundingClientRect()
        const isMobile = rect.width - RATIO < WIDTH
        AdminSidebarStore.toggleDevice(isMobile ? 'mobile' : 'other')
        AdminSidebarStore.toggleSidebar({ opened: !isMobile })
      }
    }
    document.addEventListener('visibilitychange', handler)
    window.addEventListener('DOMContentLoaded', handler)
    window.addEventListener('resize', handler)
  }
}
</script>

<style lang="sass" scoped>
@import "~bulma/bulma"
@import '~bulma/sass/utilities/initial-variables'
@import '~bulma/sass/utilities/derived-variables'
@import '~bulma/sass/utilities/mixins'
.animated
    animation-duration: .377s
html
    background-color: whitesmoke
    word-wrap: break-word
    overflow-wrap: break-word
.app-main
    padding-top: 52px
    margin-left: 230px
    @include mobile()
        margin-left: 0
.app-content
    padding: 20px
</style>
