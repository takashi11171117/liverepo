<template>
  <section class="hero is-bold app-navbar" :class="{ slideInDown: show, slideOutDown: !show }">
    <div class="hero-head">
      <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <n-link :to="{name: 'admin'}" class="navbar-item">
            <img id="logo" src="~assets/logo.svg" width="112" height="28">
          </n-link>

          <div class="navbar-item is-expanded login">
            <div class="admin">
              <p v-if="$nuxt.$route.path !== '/admin/login' && admin !== null" id="account">
                <b-icon icon="account" size="is-small" /> ようこそ {{ admin.name }}さん
              </p>
            </div>
            <div class="buttons">
              <a v-if="$nuxt.$route.path !== '/admin/login'" id="logout" class="button is-primary" @click="onLogout()">ログアウト</a>
            </div>
          </div>

          <a
            role="button"
            class="navbar-burger burger is-hidden-tablet"
            :class="{ 'is-active': menuActive }"
            aria-label="menu"
            aria-expanded="false"
            data-target="navbarBasicExample"
            @click="menuToggle()"
          >
            <span aria-hidden="true" />
            <span aria-hidden="true" />
            <span aria-hidden="true" />
          </a>
        </div>
        <div id="navMenubd-example" class="navbar-menu is-hidden-tablet" :class="{ 'is-active': menuActive }">
          <div class="navbar-start">
            <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link  is-active" href="#">
                General
              </a>
              <div class="navbar-dropdown ">
                <a class="navbar-item " href="#">
                  Dashboard
                </a>
                <a class="navbar-item " href="#">
                  Customers
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import { AdminAuthStore } from '@/store'

@Component({})
export default class Index extends Vue {
  @Prop() show!: boolean

  menuActive = false

  get admin () {
    return AdminAuthStore.getAdmin
  }

  menuToggle () {
    this.menuActive = !this.menuActive
  }

  onLogout () {
    AdminAuthStore.logout();
    (this as any).$router.push('/admin/login')
  }
}
</script>

<style lang="sass" scoped>
.admin
    padding-right: 20px
.app-navbar
    position: fixed
    min-width: 100%
    z-index: 1024
    background-color: #FFD83D
    box-shadow: 0 2px 3px rgba(17, 17, 17, 0.1), 0 0 0 1px rgba(17, 17, 17, 0.1)
.navbar .navbar-brand
    flex-grow: 1
    .login
        justify-content: flex-end
        align-items: center
        display: flex
.navbar-item img
    width: 112px
</style>
