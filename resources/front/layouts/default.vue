<template>
  <div class="site">
    <Header />
    <div class="wrapper">
      <nuxt class="site-content"/>
    </div>
    <Footer />
  </div>
</template>
<script>
  import Header from './parcial/front/Header.vue'
  import Footer from './parcial/front/Footer.vue'

  export default {
    components: {
      Header,
      Footer
    },
  }
</script>
<style lang="sass">
  /* リセット */
  html, body, div, span, applet, object, iframe,
  h1, h2, h3, h4, h5, h6, p, blockquote, pre,
  a, abbr, acronym, address, big, cite, code,
  del, dfn, em, img, ins, kbd, q, s, samp,
  small, strike, strong, sub, sup, tt, var,
  b, u, i, center,
  dl, dt, dd, ol, ul, li,
  fieldset, form, label, legend,
  table, caption, tbody, tfoot, thead, tr, th, td,
  article, aside, canvas, details, embed,
  figure, figcaption, footer, header, hgroup,
  menu, nav, output, ruby, section, summary,
  time, mark, audio, video
    margin: 0
    padding: 0
    border: 0
    font: inherit
    font-size: 100%
    vertical-align: baseline

  /* HTML5 display-role reset for older browsers */
  article, aside, details, figcaption, figure,
  footer, header, hgroup, menu, nav, section
    display: block

  body
    line-height: 1
    font-family: 'Noto Sans JP', sans-serif
    word-wrap: break-word
    overflow-wrap: break-word

  ol, ul
    list-style: none

  blockquote, q
    quotes: none

  blockquote:before, blockquote:after,
  q:before, q:after
    content: ''

  table
    border-collapse: collapse
    border-spacing: 0

  *, *:before, *:after
    box-sizing: border-box

  /* footer　固定用 */
  .site
    display: flex
    min-height: 100vh
    flex-direction: column

  img
    width: 100%
    height: auto

  a:hover
      opacity: .8

  .select:not(.is-multiple):not(.is-loading):after
    border-color: #000
    right: 1.125em
    z-index: 4

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

