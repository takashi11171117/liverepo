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
              <b-button>
                <n-link :to="{ name: 'users-name-follow_reports', params: {name: user.name} }">
                  いいねした記事
                </n-link>
              </b-button>
              <b-button>
                <n-link :to="{ name: 'users-name-followers', params: {name: user.name} }">
                  フォロワー
                </n-link>
              </b-button>
            </div>
            <nuxt-child :user="user" />
          </section>
        </div>
      </div>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { nuxtContext } from '@/src/@types'
import { UserStore, ReportStore } from '@/store'
import Pagination from '@/components/Pagination.vue'
import SideUserPage from '@/components/front/modules/SideUserPage.vue'
import UserReportCard from '@/components/front/UserReportCard.vue'
import FollowerCard from '@/components/front/FollowerCard.vue'

@Component({
  components: {
    SideUserPage,
    UserReportCard,
    FollowerCard,
    Pagination
  },
  middleware: [
    'redirectIfGuest'
  ],
  watchQuery: ['page']
})
export default class User extends Vue {
  get user (): Object {
    return UserStore.getUser
  }

  get reports (): Object {
    return ReportStore.getReports
  }

  async fetch (this: void, ctx: nuxtContext): Promise<void> {
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
