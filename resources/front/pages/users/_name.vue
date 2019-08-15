<template>
    <div class="columns">
        <aside class="column is-narrow-desktop is-narrow-tablet side-content">
            <SideUserPage :user="userData.user"/>
        </aside>
        <main class="column">
            <div class="columns is-multiline">
                <div class="column">
                    <section class="tab">
                        <b-tabs type="is-boxed">
                            <!--履歴-->
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
                                    <div v-if="userData.reports.length" >
                                        <div v-for="(report) in userData.reports" class="column is-12-mobile">
                                            <UserReportCard :report="report"/>
                                        </div>
                                    </div>
                                    <template v-else>
                                        <p>まだ投稿はありません。</p>
                                    </template>
                                </section>
                            </b-tab-item>
                            <!--いいねしている-->
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
                                        <div v-for="(report) in userData.follow_reports" class="column is-12-mobile">
                                            <UserReportCard :report="report"/>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <p>まだ投稿はありません。</p>
                                    </template>
                                </section>
                            </b-tab-item>
                            <!--フォロワー-->
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
                                        <div v-for="(follower) in userData.user.followers" class="column is-12-mobile">
                                            <FollowerCard :follower="follower"/>
                                        </div>
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
    </div>
</template>
<script>
  import Pagination from '../../components/Pagination';
  import SideUserPage from '../../components/front/modules/SideUserPage';
  import UserReportCard from '../../components/front/UserReportCard';
  import FollowerCard from '../../components/front/FollowerCard';

  export default{
    watchQuery: ['page'],

    components: {
      Pagination,
      SideUserPage,
      UserReportCard,
      FollowerCard
    },

    data() {
      return {
        userData: {},
      }
    },

    async asyncData({$axios, query, params, $auth, app}){
      const userData = await $axios.$get(`users/${params.name}`, {
        params: {
          page: query.page,
        }
      });

      return {userData};
    },
  }
</script>
<style lang="sass" scoped>
    .main-content
        background-color: #fff
        border-radius: 8px
        padding: 15px 20px
        h1
            font-size: 20px
            font-weight: bold
            line-height: 1.2

    .side-content
        @media screen and (min-width: 768px)
            width: 320px

    .content
        display: flex

    .b-tabs
        border-radius: 10px

    .tab /deep/ .is-boxed
        margin-bottom: 0

    .tab /deep/ .tab-content
        border-radius: 10px
        padding: 0
        margin-top: 10px
</style>