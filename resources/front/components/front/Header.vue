<template>
    <header>
        <h1 class="index-page">レポートを書いたらライブに行ける！お笑いライブレポ</h1>
        <div class="clearfix navBarMenu">
            <div class="nav-menu">
                <i class="fas fa-bars fa-2x"></i>
                <div>メニュー</div>
            </div>
            <div class="nav-logo">
                <n-link :to="{ name: 'index' }">
                    <img id="logo" src="~assets/logo.svg" width="112" height="28">
                </n-link>
            </div>
            <div id="nav-right">
                <div class="nav-search">
                    <i class="fas fa-search fa-2x"></i>
                </div>
                <template v-if="!$auth.loggedIn">
                    <div class="nav-login">
                        <n-link :to="{ name: 'auth-login' }" id="login" class="button">
                            ログイン
                        </n-link>
                    </div>
                </template>
                <template v-if="$auth.loggedIn">
                    <div class="nav-post-report">
                        <n-link :to="{ name: 'user-post' }" id="post-report" class="button">
                            投稿する
                        </n-link>
                    </div>
                    <div class="user-menu">
                        <b-dropdown position="is-bottom-left" aria-role="menu">
                            <a
                                    class="navbar-item"
                                    slot="trigger"
                                    role="button">
                                <b-icon icon="menu-down"></b-icon>
                            </a>

                            <b-dropdown-item aria-role="menu-item" has-link>
                                <n-link :to="{ name: 'user' }" id="mypage">
                                    マイページ
                                </n-link>
                            </b-dropdown-item>
                            <b-dropdown-item aria-role="menu-item">アカウント設定</b-dropdown-item>
                            <hr class="dropdown-divider">
                            <b-dropdown-item @click="$auth.logout()" aria-role="menu-item">ログアウト</b-dropdown-item>
                        </b-dropdown>
                    </div>
                </template>
            </div>
        </div>
        <div class="main_image">
            <!--<img src="images/main_image.png" alt="LIVE REPO">-->
        </div>
        <nav>
            <ul class="clearfix">
                <li><a href="#">新着</a></li>
                <li><a href="#">トレンド</a></li>
            </ul>
        </nav>
    </header>
</template>

<style :type="scss" scoped>
    h1{
        background-color: #000;
        color: #fff;
        padding: 10px;
        font-size: 12px;
    }

    .navBarMenu{
        background-color: #f8d048;
        padding: 15px 0px 15px 0px;
    }

    #nav-right {
        float: right;
    }

    #nav-right > div {
        float: left;
    }

    .nav-menu {
        padding-top: 5px;
        padding-right: 8px;
        padding-left: 15px;
        float: left;

    }
    .nav-menu div {
        font-size: 8px;
        font-weight: bold;
    }
    .nav-logo {
        float: left;
    }

    .nav-logo img {
        padding-top: 5px;
        width: 100px;
        /* float: left; */
    }

    .nav-search {
        padding-top: 8px;
        padding-right: 10px;
    }

    .nav-login,
    .nav-post-report{
        padding-top: 5px;
        padding-right: 15px;
    }

    .button {
        font-weight: bold;
        font-size: 14px;
        padding-top: 18px;
        padding-bottom: 18px;
        padding-left: 15px;
        padding-right: 15px;
    }

    nav {
        background-color: #000;
    }

    nav ul {
        margin: 0 auto;
    }
    nav ul li {
        float: left;
        position: relative;
    }

    nav ul li a {
        color: #fff;
        font-size: 20px;
        text-decoration: none;
        text-align: center;
        padding: 15px 30px;
        padding-bottom: 18px;
        display: inline-block;
    }

    nav ul li::after {
        position: absolute;
        content: '';
        display: inline-block;
        width: 2px;
        height: 20px;
        top: calc(50% - 10px);
        left: 100%;
        background-color: #fff;
    }

    nav ul li:last-child::after {
        height: 0;
    }
</style>