<template>
  <div class="columns">
    <aside class="column is-narrow-desktop is-narrow-tablet">
      <ReportCalendar />
    </aside>
    <main class="column">
      <div v-if="$isset(reports.data)" class="columns is-mobile is-tablet is-multiline">
        <div
          v-for="report in reports.data"
          :key="report.id"
          class="column is-12-mobile is-6-tablet is-6-desktop"
        >
          <ReportIndexCard :report="report" />
        </div>
      </div>
      <Pagination
        v-if="reports.data !== undefined && Object.keys(reports.data).length > 0"
        current_path="/"
        :pagination="reports.meta"
      />
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'
import { ReportStore, CalendarStore } from '@/store'
import ReportIndexCard from '@/components/front/ReportIndexCard.vue'
import ReportCalendar from '@/components/front/ReportCalendar.vue'
import Pagination from '@/components/Pagination.vue'

@Component({
  components: {
    ReportIndexCard,
    ReportCalendar,
    Pagination
  },
  watchQuery: ['page', 'per_page']
})
export default class Index extends Vue {
  get reports (): Object {
    return ReportStore.getReports
  }

  async fetch (this: void, ctx: Context) {
    const today = new Date()
    const month = ('0' + (today.getMonth() + 1)).slice(-2)
    await CalendarStore.fetchAttributes(`${today.getFullYear()}-${month}`)

    await ReportStore.loadReports({
      page: ctx.app.context.query.page,
      per_page: ctx.app.context.query.per_page,
      s: ''
    })
  }
}
</script>
