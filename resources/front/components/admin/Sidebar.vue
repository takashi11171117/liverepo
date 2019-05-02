<template>
    <aside class="menu app-sidebar" :class="{ slideInLeft: show, slideOutLeft: !show }">
        <p class="menu-label">
            メニュー
        </p>
        <ul class="menu-list">
            <li><a id="nav-dashboard">ダッシュボード</a></li>
            <li>
                <n-link id="nav-user" :to="{ path: `/admin` }">
                    ユーザー
                </n-link>
            </li>
        </ul>
    </aside>
</template>

<script>
  export default {
    data: () => {
      return {}
    },
    props: {
      show: Boolean
    },
  }
</script>

<style lang="scss">
    @import '~bulma/sass/utilities/initial-variables';
    @import '~bulma/sass/utilities/derived-variables';
    @import '~bulma/sass/utilities/mixins';
    .app-sidebar {
        position: fixed;
        top: 52px;
        left: 0;
        bottom: 0;
        padding: 20px 10px 50px;
        width: 230px;
        min-width: 45px;
        max-height: 100vh;
        height: calc(100% - 52px);
        z-index: 1024 - 1;
        background: #FFF;
        overflow-y: auto;
        overflow-x: hidden;
        @include mobile() {
            transform: translate3d(-230px, 0, 0);
        }
        .icon {
            vertical-align: baseline;
            &.is-angle {
                position: absolute;
                right: 10px;
                transition: transform .377s ease;
            }
        }
        .menu-label {
            padding-left: 5px;
        }
        .menu-list {
            li a {
                &[aria-expanded="true"] {
                    .is-angle {
                        transform: rotate(180deg);
                    }
                }
            }
            li a + ul {
                margin: 0 10px 0 15px;
            }
        }
    }
</style>