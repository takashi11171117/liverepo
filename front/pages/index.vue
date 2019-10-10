<template>
  <div class="columns">
    <aside
      class="column is-narrow-desktop is-narrow-tablet"
    >
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
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { ReportStore, CalendarStore } from '@/store'
import ReportIndexCard from '@/components/front/ReportIndexCard.vue'
import ReportCalendar from '@/components/front/ReportCalendar.vue'

@Component({
  components: {
    ReportIndexCard,
    ReportCalendar
  }
})
export default class Index extends Vue {
  get reports (): Object {
    return ReportStore.getReports
  }

  async fetch () {
    const today = new Date()
    const month = ('0' + (today.getMonth() + 1)).slice(-2)
    await CalendarStore.fetchAttributes(`${today.getFullYear()}-${month}`)
  }

  async asyncData (): Promise<void> {
    await ReportStore.loadReports()
  }
}
</script>
