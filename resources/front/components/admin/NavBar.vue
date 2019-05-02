<template>
    <section class="hero is-bold app-navbar" :class="{ slideInDown: show, slideOutDown: !show }">
        <div class="hero-head">
            <nav class="navbar" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <a class="navbar-item" href="https://bulma.io">
                        <img id="logo" src="~assets/logo.svg" width="112" height="28">
                    </a>

                    <div class="navbar-item is-expanded login">
                        <div class="admin">
                            <p id="account" v-if="$nuxt.$route.path !== '/admin/login' && admin !== null">
                                <b-icon icon="account" size="is-small"></b-icon> ようこそ {{ admin.name }}さん
                            </p>
                        </div>
                        <div class="buttons">
                            <a id="logout" @click="onLogout()" class="button is-primary" v-if="$nuxt.$route.path !== '/admin/login'">ログアウト</a>
                        </div>
                    </div>

                    <a role="button" class="navbar-burger burger is-hidden-tablet" v-bind:class="{ 'is-active': menuActive }" v-on:click="menuToggle()"  aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>
                <div id="navMenubd-example" class="navbar-menu is-hidden-tablet" v-bind:class="{ 'is-active': menuActive }">
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

<script>
  import { mapActions } from 'vuex';

  export default {
    data(){
      return{
        menuActive: false,
        admin: {}
      }
    },
    created() {
      this.admin = this.$store.getters['admin'];
    },
    props: {
      show: Boolean
    },
    methods: {
      menuToggle(){
        this.menuActive = !this.menuActive;
      },
      onLogout(){
        this.logout();
      },
      ...mapActions(['logout'])
    }
  }
</script>

<style lang="scss">
    .admin {
        padding-right: 20px;
    }
    .app-navbar {
        position: fixed;
        min-width: 100%;
        z-index: 1024;
        background-color: #FFD83D;
        box-shadow: 0 2px 3px rgba(17, 17, 17, 0.1), 0 0 0 1px rgba(17, 17, 17, 0.1);
    }
    .navbar .navbar-brand {
        flex-grow: 1;
        .login {
            justify-content: flex-end;
            align-items: center;
            display: flex;
        }
    }
</style>