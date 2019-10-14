<template>
  <header>
    <h1 class="index-page">
      レポートを書いたらライブに行ける！お笑いライブレポ
    </h1>
    <div class="navBarMenu">
      <div class="nav-logo">
        <div class="nav-logo">
          <n-link id="logo" :to="{ name: 'index' }">
            <img src="~assets/logo.svg" width="112" height="28">
          </n-link>
        </div>
        <div class="nav-search">
          <i class="fas fa-search fa-2x" />
        </div>
        <template v-if="!$auth.loggedIn">
          <div class="nav-new-user">
            <n-link id="new-user" :to="{ name: 'auth-register' }" class="button">
              会員登録
            </n-link>
          </div>
          <div class="nav-login">
            <n-link id="login" :to="{ name: 'auth-login' }" class="button">
              ログイン
            </n-link>
          </div>
        </template>

        <template v-if="$auth.loggedIn">
          <div class="nav-post-report">
            <n-link id="post-report" :to="{ name: 'setting-post' }" class="button">
              投稿する
            </n-link>
          </div>
          <div class="user-menu">
            <b-dropdown position="is-bottom-left" aria-role="menu">
              <a
                slot="trigger"
                class="dropdown-button"
                role="button"
              >
                <b-icon icon="menu-down" />
              </a>

              <b-dropdown-item aria-role="menu-item" has-link>
                <n-link id="mypage" :to="{ name: 'users-name', params: {name: $auth.user.name} }">
                  マイページ
                </n-link>
              </b-dropdown-item>
              <b-dropdown-item aria-role="menu-item" has-link>
                <n-link id="account" :to="{ name: 'setting-profile' }">
                  アカウント設定
                </n-link>
              </b-dropdown-item>
              <hr class="dropdown-divider">
              <b-dropdown-item aria-role="menu-item" @click="$auth.logout()">
                ログアウト
              </b-dropdown-item>
            </b-dropdown>
          </div>
        </template>
      </div>
    </div>
    <nav>
      <ul>
        <li>
          <n-link :to="{ name: 'comedy-report_tags' }">
            タグ一覧
          </n-link>
        </li>
      </ul>
    </nav>
  </header>
</template>

<style lang="sass" scoped>
h1
    background-color: #000
    color: #fff
    padding: 10px
    font-size: 12px
    margin: 0

.navBarMenu
    background-color: #f8d048
    padding: 15px 0 15px 0

.nav-menu
    padding: 5px 15px 0 8px;
    div
        font-size: 8px
        font-weight: bold

.nav-logo
    display: flex
    justify-content: flex-start
    #logo
        margin: 0 20px
    img
        padding-top: 5px
        width: 100px

.nav-search
    padding: 8px 0 0 10px

.nav-login,
.nav-post-report,
.nav-new-user
    padding: 5px 20px 0 0

.nav-new-user,
.nav-post-report
    margin-left: auto
    padding-right: 10px

.button
    font-weight: bold
    font-size: 14px
    padding: 18px 15px

nav
    background-color: #000
    ul
        display: flex
        margin: 0 auto
        li
            position: relative
            a
                color: #fff
                font-size: 20px
                text-decoration: none
                text-align: center
                padding: 15px 30px 18px 30px
                display: inline-block
            &:after
                position: absolute
                content: ''
                display: inline-block
                width: 2px
                height: 20px
                top: calc(50% - 10px)
                left: 100%
                background-color: #fff
        li:last-child
            &:after
                height: 0

.dropdown
    padding: 10px 0 10px 10px
    margin-right: 20px
</style>
