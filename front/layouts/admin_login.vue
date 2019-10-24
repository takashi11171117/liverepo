<template>
  <div class="site">
    <nav-bar :show="true" />
    <section>
      <nuxt class="has-text-centered is-fluid is-marginless app-content" />
    </section>
  </div>
</template>
<script>
import { Component, Vue } from 'nuxt-property-decorator'
import NavBar from '@/layouts/parcial/admin/NavBar.vue'

@Component({
  components: {
    NavBar
  }
})
export default class AdminLogin extends Vue {
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
</style>
