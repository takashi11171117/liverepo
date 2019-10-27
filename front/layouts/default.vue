<template>
  <div class="site">
    <Header />
    <div class="wrapper">
      <nuxt class="site-content" />
    </div>
    <Footer />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Header from '@/layouts/parcial/front/Header.vue'
import Footer from '@/layouts/parcial/front/Footer.vue'

  @Component({
    components: {
      Header,
      Footer
    }
  })
export default class Default extends Vue {
}
</script>

<style lang="sass">
.wrapper
  height: auto
  color: #000
  padding: 20px
  margin: 0 auto
  width: 100%
  max-width: 100%
  margin-bottom: auto
  position: relative
</style>
