<template>
  <div class="columns">
    <aside
      class="column is-narrow-desktop is-narrow-tablet"
    />
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
import { ReportStore } from '@/store'
import ReportIndexCard from '@/components/front/ReportIndexCard.vue'

@Component({
  components: {
    ReportIndexCard
  }
})
export default class Index extends Vue {
  get reports (): Object {
    return ReportStore.getReports
  }

  async asyncData (): Promise<void> {
    await ReportStore.loadReports()
  }
}
</script>
