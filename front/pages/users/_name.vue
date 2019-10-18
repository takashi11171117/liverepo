<template>
  <div class="columns">
    <aside class="column is-narrow-desktop is-narrow-tablet side-content">
      <SideUserPage :user="user" />
    </aside>
    <main class="column">
      <div class="columns is-multiline">
        <div class="column">
          <section class="tab">
            <div class="buttons">
              <b-button>
                <n-link :to="{ name: 'users-name', params: {name: user.name} }">
                  投稿履歴
                </n-link>
              </b-button>
              <b-button>いいねした記事</b-button>
              <b-button>フォロワー</b-button>
            </div>
            <section class="main-content border-radius report">
              <h1>投稿履歴</h1>
              <hr class="dropdown-divider">
              <div v-if="reports !== undefined && Object.keys(reports.data).length > 0">
                <div v-for="report in reports.data" :key="report.id" class="column is-12-mobile">
                  <UserReportCard :report="report" />
                </div>
                <Pagination
                  :current_path="`/users/${user.name}`"
                  :pagination="reports.meta"
                />
              </div>
              <template v-else>
                <p>まだ投稿はありません。</p>
              </template>
            </section>
          </section>
        </div>
      </div>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'
import { UserStore, ReportStore } from '@/store'
import Pagination from '@/components/Pagination.vue'
import SideUserPage from '@/components/front/modules/SideUserPage.vue'
import UserReportCard from '@/components/front/UserReportCard.vue'
import FollowerCard from '@/components/front/FollowerCard.vue'

interface nowContext extends Context {
  params: {
    name: string
  }
}

@Component({
  components: {
    SideUserPage,
    UserReportCard,
    FollowerCard,
    Pagination
  },
  watchQuery: ['page']
})
export default class User extends Vue {
  get user (): Object {
    return UserStore.getUser
  }

  get reports (): Object {
    return ReportStore.getReports
  }

  async asyncData (this: void, ctx: nowContext): Promise<void> {
    await UserStore.loadUser(ctx.params.name)
    await ReportStore.loadReportsByUser(
      ctx.params.name,
      {
        page: ctx.app.context.query.page,
        per_page: ctx.app.context.query.per_page
      }
    )
  }
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
