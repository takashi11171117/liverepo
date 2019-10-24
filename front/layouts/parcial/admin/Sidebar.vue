<template>
  <aside class="menu app-sidebar" :class="{ slideInLeft: show, slideOutLeft: !show }">
    <p class="menu-label">
      メニュー
    </p>
    <ul class="menu-list">
      <li>
        <n-link id="nav-dashboard" :to="{ name: 'admin' }">
          ダッシュボード
        </n-link>
      </li>
      <li>
        <n-link id="nav-user" :to="{ name: 'admin-admins' }">
          ユーザー
        </n-link>
      </li>
      <li>
        <n-link id="nav-report" :to="{ name: 'admin-reports' }">
          レポート
        </n-link>
      </li>
    </ul>
  </aside>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'

@Component({})
export default class AdminSidebar extends Vue {
  show = false
}
</script>

<style lang="sass" scoped>
@import '~bulma/sass/utilities/initial-variables'
@import '~bulma/sass/utilities/derived-variables'
@import '~bulma/sass/utilities/mixins'
.app-sidebar
    position: fixed
    top: 52px
    left: 0
    bottom: 0
    padding: 20px 10px 50px
    width: 230px
    min-width: 45px
    max-height: 100vh
    height: calc(100% - 52px)
    z-index: 1024 - 1
    background: #FFF
    overflow-y: auto
    overflow-x: hidden
    @include mobile()
        transform: translate3d(-230px, 0, 0)

    .icon
        vertical-align: baseline
        &.is-angle
            position: absolute
            right: 10px
            transition: transform .377s ease

    .menu-label
        padding-left: 5px

    .menu-list
        li a
            &[aria-expanded="true"]
                .is-angle
                    transform: rotate(180deg)
        li a + ul
            margin: 0 10px 0 15px
</style>
