<template>
    <main class="main">
        <div class="columns is-multiline">
            <div class="column is-narrow-desktop is-narrow-tablet side-content">
                <section class="main-content">
                    <p class="user-img">
                        <template v-if="$auth.user.src !== undefined">
                            <img :src="$auth.user.src">
                        </template>
                        <template v-else>
                            <img src="~assets/none_image.jpg">
                        </template>
                    </p>
                    <h1>@{{ $auth.user.name }}</h1>
                    <template v-if="$isset($auth.user.user_name01)|| $isset($auth.user.user_name02)">
                        <template v-if="$isset($auth.user.user_name01)">{{ $auth.user.user_name01 }} </template>
                        <template v-if="$isset($auth.user.user_name02)">{{ $auth.user.user_name02 }}</template>
                    </template>
                    <p>{{ $calcAge($auth.user.birth) }} / {{ $data.genderOption[$auth.user.gender] }} / states</p>
                    <hr class="dropdown-divider">
                    <template v-if="$isset($auth.user.email)">
                        <p>
                            {{ $auth.user.email }}
                        </p>
                        <hr class="dropdown-divider">
                    </template>
                    <p>
                        <n-link :to="{ name: 'setting-profile' }">
                            プロフィールを編集
                        </n-link>
                    </p>
                    <hr class="dropdown-divider">
                    <template v-if="$isset($auth.user.description)">
                        <p>
                            {{ $auth.user.description }}
                        </p>
                        <hr class="dropdown-divider">
                    </template>
                    <template v-if="$isset($auth.user.url)">
                        <p>
                            {{ $auth.user.url }}
                        </p>
                        <hr class="dropdown-divider">
                    </template>
                    <div class="follow-tag">
                        フォロー中のタグ
                        <ul class="tags">
                            <li>ヤング</li>
                            <li>漫才</li>
                        </ul>
                    </div>
                    <hr class="dropdown-divider">
                    <p>
                        フォロー中のユーザー
                    </p>
                    <hr class="dropdown-divider">
                </section>
            </div>
            <div class="column">
                <section>
                    <b-tabs type="is-boxed">
                        <b-tab-item>
                            <template slot="header">
                                <b-icon icon="information-outline"></b-icon>
                                <span> 投稿履歴 <b-tag rounded> 3 </b-tag> </span>
                            </template>
                        </b-tab-item>
                        <b-tab-item>
                            <template slot="header">
                                <b-icon icon="source-pull"></b-icon>
                                <span> フォロワー <b-tag rounded> 100 </b-tag> </span>
                            </template>
                        </b-tab-item>
                    </b-tabs>
                    <section class="main-content border-radius">
                        <h1>投稿履歴</h1>
                        <hr class="dropdown-divider">
                        <section v-if="reports.data !== undefined" v-for="(report) in reports.data" class="column is-12-mobile is-6-tablet is-6-desktop">
                            <UserData :user="report.user"/>
                            <h1>{{ $truncate(report.title, 30) }}</h1>
                            <div class="content">
                                <ReviewStars :report="report"/>
                                <template v-if="report.report_images !== undefined && report.report_images.length > 0">
                                    <img :src="report.report_images[0].path" alt="thumbnail" class="thumbnail">
                                </template>
                                <template v-else>
                                    <img src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
                                </template>
                            </div>
                            <div class="dropdown-divider"></div>
                        </section>
                        <section>
                            <p>まだ投稿はありません。</p>
                        </section>
                    </section>
                </section>
            </div>
        </div>
    </main>
</template>
<script>
  import Pagination from '../../components/Pagination';
  import UserData from '../../components/front/UserData';
  import ReviewStars from '../../components/front/ReviewStars';

  export default{
    watchQuery: ['page'],
    middleware: [
      'redirectIfGuest'
    ],
    components: {
      Pagination,
      UserData,
      ReviewStars,
    },
    data() {
      return {
        reports: {},
      }
    },
    async asyncData({$axios, query, app}){
      const reports = await $axios.$get(`setting/report/${app.$auth.$state.user.id}`, {
        params: {
          page: query.page,
        }
      });

      return {reports};
    }
  }
</script>
<style lang="sass" scoped>
    main
        background-color: #f8d048
        height: auto
        color: #000
        padding-top: 20px
        padding-bottom: 20px
        padding-left: 20px
        padding-right: 20px

    .main-content
        background-color: #fff
        border-radius: 8px
        padding: 15px 20px
        h1
            padding: 10px 0 10px 0
            font-size: 20px
            font-weight: bold
            line-height: 1.2

    .tagpage-box
        text-align: center
    .side-content
        padding-bottom: 20px
        margin-bottom: 20px
        text-align: left
        h1
            padding-top: 0
            padding-bottom: 0
        p, div
            margin-top: 10px
            margin-bottom: 10px
            font-size: 14px
            line-height: 1.5
        .follow-tag
            margin-bottom: 20px
        @media screen and (min-width: 768px)
            width: 320px
    .user-img
        margin-bottom: 10px
        img
            border-radius: 5px
    .tags
        margin-bottom: 10px
        margin-top: 10px
    .tags li
        display: inline-block
        position: relative
        padding: 0.2em 1.4em
        margin-right: 10px
        background: #fff
        color: #000
        border-top: solid 0.5px #000
        border-left: solid 0.5px #000
        border-bottom: solid 5px #000
        border-right: solid 5px #000
        font-size: 12px
        font-weight: bold
        &:before
            content: " "
            position: absolute
            bottom: -5px
            left: -1px
            width: 0
            height: 0
            border-width: 0 6px 6px 0
            border-style: solid
            border-color: transparent
            border-bottom-color: #FFF
        &:after
            content: " "
            position: absolute
            top: -1px
            right: -5px
            width: 0
            height: 0
            border-width: 0px 6px 6px 0px
            border-style: solid
            border-color: #FFF
            border-bottom-color: transparent

    .content
        display: flex

    .thumbnail
        width: 120px
        height: auto

    div.dropdown-divider
        margin-bottom: 10px
</style>