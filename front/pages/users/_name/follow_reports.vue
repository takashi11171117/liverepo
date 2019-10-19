<template>
  <section class="main-content border-radius report">
    <h1>投稿履歴</h1>
    <hr class="dropdown-divider">
    <div v-if="reports !== undefined && Object.keys(reports.data).length > 0">
      <div v-for="report in reports.data" :key="report.id" class="column is-12-mobile">
        <UserReportCard :report="report" />
      </div>
      <Pagination
        :current_path="`/users/${user.name}/follow_reports`"
        :pagination="reports.meta"
      />
    </div>
    <template v-else>
      <p>まだ投稿はありません。</p>
    </template>
  </section>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'
import { ReportStore } from '@/store'
import Pagination from '@/components/Pagination.vue'
import UserReportCard from '@/components/front/UserReportCard.vue'

interface nowContext extends Context {
  params: {
    name: string
  }
}

@Component({
  components: {
    UserReportCard,
    Pagination
  },
  watchQuery: ['page']
})
export default class User extends Vue {
  @Prop() user: Object

  get reports (): Object {
    return ReportStore.getReports
  }

  async fetch (this: void, ctx: nowContext): Promise<void> {
    await ReportStore.loadReportsByFollower(
      ctx.params.name,
      {
        page: ctx.app.context.query.page,
        per_page: ctx.app.context.query.per_page
      }
    )
  }
}
</script>
