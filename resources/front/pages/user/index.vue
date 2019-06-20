<template>
    <main class="main">
        <div class="columns is-mobile is-multiline">
            <div class="column is-12-mobile is-4-tablet is-4-desktop tagpage-box">
                <section class="main-content side-content">
                    <p class="user-img"><img src="https://placehold.jp/300x300.png" alt=""></p>
                    <h1>@{{ $auth.user.name }}</h1>
                    <p>20代/女性/大阪府</p>
                    <hr class="dropdown-divider">
                    <p><a href="#">プロフィールを編集</a></p>
                    <hr class="dropdown-divider">
                    <p>
                        大阪の漫才が好きでっせ。<br />
                        みんなみにいきまひょ。
                    </p>
                    <hr class="dropdown-divider">
                    <p>
                        URL: http://fools.com
                    </p>
                    <hr class="dropdown-divider">
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
            <div class="column is-12-mobile is-8-tablet is-8-desktop">
                <section class="main-content border-radius">
                    <template v-if="reports.data !== undefined" v-for="(report) in reports.data" class="column is-12-mobile is-6-tablet is-6-desktop">
                        <div class="is-clearfix user-data">
                            <div class=user-icon>
                                <!--<img src="images/download.jpg"  class=border-radius alt="user icon">-->
                            </div>
                            <div class=user-name>By user name</div>
                            <div class=user-profile>age / gender / states</div>
                        </div>
                        <h1>{{ $truncate(report.title, 30) }}</h1>
                        <div class="is-clearfix">
                            <img v-if="report.report_images !== undefined && report.report_images.length > 0" :src="report.report_images[0].path" alt="thumbnail" class="thumbnail">
                            <img v-if="report.report_images !== undefined && report.report_images.length === 0" src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
                            <div class="clearfix review-content">
                                <div class="review-star">
                                    <div class="star-rating">
                                        <div class="star-rating-front" :style="'width: ' + report.rating/5*100 + '%'">★★★★★</div>
                                        <div class="star-rating-back">★★★★★</div>
                                    </div>
                                    <div class="star-number">{{ report.rating }}</div>
                                </div>
                                <p class="review-text">{{ $truncate(report.content, 80) }}</p>
                            </div>
                        </div>
                        <hr class="dropdown-divider">
                    </template>
                </section>
            </div>
        </div>
    </main>
</template>
<script>
  import Pagination from '../../components/admin/Pagination'

  export default{
    watchQuery: ['page'],
    middleware: [
      'redirectIfGuest'
    ],
    components: {
      Pagination,
    },
    data() {
      return {
        reports: {},
      }
    },
    async asyncData({$axios, query, app}){
      const reports = await $axios.$get(`user/report/${app.$auth.$state.user.id}`, {
        params: {
          page: query.page,
        }
      });

      return {reports};
    }
  }
</script>
<style lang="sass">
    .tagpage-box
        text-align: center
    .side-content
        padding-top: 20px
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
</style>