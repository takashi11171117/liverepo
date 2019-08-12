<template>
    <main class="main">
        <div class="columns is-multiline">
            <div class="column is-narrow-desktop is-narrow-tablet side-content">
                <section class="main-content">
                    <p class="user-img">
                        <template v-if="userData.user.src !== undefined">
                            <img :src="userData.user.src">
                        </template>
                        <template v-else>
                            <img src="~assets/none_image.jpg">
                        </template>
                    </p>
                    <h1>@{{ userData.user.name }}</h1>
                    <template v-if="$isset(userData.user.user_name01)|| $isset(userData.user.user_name02)">
                        <template v-if="$isset(userData.user.user_name01)">{{ userData.user.user_name01 }} </template>
                        <template v-if="$isset(userData.user.user_name02)">{{ userData.user.user_name02 }}</template>
                    </template>
                    <p>{{ $calcAge(userData.user.birth) }} / {{ $data.genderOption[userData.user.gender] }} / {{ $data.prefsOption[userData.user.pref] }}</p>
                    <Follow
                            :eachData="userData.user"
                            :currentFollowing="currentFollowing"
                            followType="follow_users"
                    />
                    <hr class="dropdown-divider">
                    <template v-if="$isset(userData.user.email)">
                        <p>
                            {{ userData.user.email }}
                        </p>
                        <hr class="dropdown-divider">
                    </template>
                    <template v-if="$auth.$state.loggedIn && (userData.user.name === $auth.user.name)">
                        <p>
                            <n-link :to="{ name: 'setting-profile' }">
                                プロフィールを編集
                            </n-link>
                        </p>
                        <hr class="dropdown-divider">
                    </template>
                    <template v-if="$isset(userData.user.description)">
                        <p>
                            {{ userData.user.description }}
                        </p>
                        <hr class="dropdown-divider">
                    </template>
                    <template v-if="$isset(userData.user.url)">
                        <p>
                            <a :href="userData.user.url" target="_blank">
                                {{ userData.user.url }}
                            </a>
                        </p>
                        <hr class="dropdown-divider">ß
                    </template>
                    <div class="follow-tag">
                        フォロー中のタグ <b-tag rounded> {{ userData.user.follow_report_tags.length }} </b-tag>
                        <div class="report-tags">
                            <template v-for="tagName in userData.user.follow_report_tags">
                                <Tag :tagName="tagName"/>
                            </template>
                        </div>
                    </div>
                    <hr class="dropdown-divider">
                    <div>
                        フォロー中のユーザー <b-tag rounded> {{ userData.user.follow_users.length }} </b-tag>
                        <template v-if="userData.user.follow_users.length">
                            <div class="columns users">
                                <div class="column is-2" v-for="user in userData.user.follow_users">
                                    <n-link :to="{ name: 'users-name', params: {name: user.name} }" id="user-data">
                                        <img :src="user.thumb" alt="">
                                    </n-link>
                                </div>
                            </div>
                        </template>
                    </div>
                    <hr class="dropdown-divider">
                </section>
            </div>
            <div class="column">
                <section class="tab">
                    <b-tabs type="is-boxed">
                        <b-tab-item>
                            <template slot="header">
                                <b-icon icon="information-outline"></b-icon>
                                <span>
                                    投稿履歴
                                    <b-tag rounded> {{ userData.reports.length }} </b-tag>
                                </span>
                            </template>
                            <section class="main-content border-radius report">
                                <h1>投稿履歴</h1>
                                <hr class="dropdown-divider">
                                <template v-if="userData.reports.length" >
                                    <section v-for="(report) in userData.reports" class="column is-12-mobile">
                                        <UserData :user="report.user"/>
                                        <h1>{{ $truncate(report.title, 30) }}</h1>
                                        <div class="content">
                                            <div class="review-content">
                                                <ReviewStars :report="report"/>
                                                <p class="review-text">{{ $truncate(report.content, 80) }}</p>
                                            </div>
                                            <template v-if="report.report_images !== undefined && report.report_images.length > 0">
                                                <img :src="report.report_images[0].path" alt="thumbnail" class="thumbnail">
                                            </template>
                                            <template v-else>
                                                <img src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
                                            </template>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    </section>
                                </template>
                                <template v-else>
                                    <p>まだ投稿はありません。</p>
                                </template>
                            </section>
                        </b-tab-item>
                        <b-tab-item>
                            <template slot="header">
                                <b-icon icon="information-outline"></b-icon>
                                <span>
                                    いいねしているレポート
                                    <b-tag rounded> {{ userData.follow_reports.length }} </b-tag>
                                </span>
                            </template>
                            <section class="main-content border-radius report">
                                <h1>いいねしているレポート</h1>
                                <hr class="dropdown-divider">
                                <template v-if="userData.follow_reports.length" >
                                    <section v-for="(report) in userData.follow_reports" class="column is-12-mobile">
                                        <UserData :user="report.user"/>
                                        <h1>{{ $truncate(report.title, 30) }}</h1>
                                        <div class="content">
                                            <div class="review-content">
                                                <ReviewStars :report="report"/>
                                                <p class="review-text">{{ $truncate(report.content, 80) }}</p>
                                            </div>
                                            <template v-if="report.report_images !== undefined && report.report_images.length > 0">
                                                <img :src="report.report_images[0].path" alt="thumbnail" class="thumbnail">
                                            </template>
                                            <template v-else>
                                                <img src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
                                            </template>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    </section>
                                </template>
                                <template v-else>
                                    <p>まだ投稿はありません。</p>
                                </template>
                            </section>
                        </b-tab-item>
                        <b-tab-item>
                            <template slot="header">
                                <b-icon icon="source-pull"></b-icon>
                                <span>
                                    フォロワー
                                    <b-tag rounded>
                                        {{ userData.user.followers.length }}
                                    </b-tag>
                                </span>
                            </template>
                            <section class="main-content border-radius">
                                <h1>フォロワー</h1>
                                <hr class="dropdown-divider">
                                <template v-if="userData.user.followers.length" >
                                    <section v-for="(follower) in userData.user.followers" class="column is-12-mobile">
                                        <div class="follow-user-data">
                                            <n-link :to="{ name: 'users-name', params: {name: follower.name} }">
                                                <div class="user-icon">
                                                    <template v-if="follower.thumb !== null && follower.thumb !== undefined">
                                                        <img :src="follower.thumb">
                                                    </template>
                                                    <template v-else>
                                                        <img src="~assets/none_image.jpg">
                                                    </template>
                                                </div>
                                                <div class="user-info">
                                                    <h1>{{ follower.name }}</h1>
                                                    <p>{{ follower.description }}</p>
                                                </div>
                                            </n-link>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    </section>
                                </template>
                                <template v-else>
                                    <p>まだフォロワーはいません。</p>
                                </template>
                            </section>
                        </b-tab-item>
                    </b-tabs>
                </section>
            </div>
        </div>
    </main>
</template>
<script>
  import Pagination from '../../components/Pagination';
  import UserData from '../../components/front/UserData';
  import ReviewStars from '../../components/front/ReviewStars';
  import Tag from '../../components/front/Tag';
  import Follow from '../../components/Follow';

  export default{
    watchQuery: ['page'],
    components: {
      Pagination,
      UserData,
      ReviewStars,
      Tag,
      Follow
    },
    data() {
      return {
        userData: {},
        currentFollowing: false,
      }
    },
    async asyncData({$axios, query, params, $auth, app}){
      const userData = await $axios.$get(`users/${params.name}`, {
        params: {
          page: query.page,
        }
      });

      let currentFollowing = false;
      if (app.$auth.$state.loggedIn) {
        const tempFollow = await $axios.$get(`/follow_users/${userData.user.id}`);
        currentFollowing = tempFollow.result
      }

      return {userData, currentFollowing};
    },
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
                font-size: 20px
                font-weight: bold
                line-height: 1.2

        .report
            h1
                padding-bottom: 20px

        .review-content
            overflow: hidden
            width: calc(100% - 120px)
            display: flex
            flex-direction: column

        .review-text
            padding-right: 10px
            line-height: 150%
            margin-bottom: 10px
            font-size: 16px

        .tagpage-box
            text-align: center
        .side-content
            padding-bottom: 20px
            margin-bottom: 20px
            text-align: left
            h1
                padding-top: 0
                padding-bottom: 0
            p, > div
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
        .report-tags
            margin-bottom: 10px
            margin-top: 10px

        .content
            display: flex

        .thumbnail
            width: 120px
            height: auto

        div.dropdown-divider
            margin-bottom: 10px

        .b-tabs
            border-radius: 10px

        .tab /deep/ .is-boxed
            margin-bottom: 0

        .tab /deep/ .tab-content
            border-radius: 10px
            padding: 0
            margin-top: 10px
    .users
        margin-top: 4px
        img
            border-radius: 5px

    .follow-user-data a
        color: #000
        display: flex
        .user-icon
            width: 80px
            padding-right: 10px
            img
                border-radius: 5px
        .user-info
            width: calc(100% - 90px)
        h1
            padding-top: 0
            padding-bottom: 10px;
</style>