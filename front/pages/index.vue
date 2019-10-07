<template>
  <div class="columns">
    <aside
      class="column is-narrow-desktop is-narrow-tablet"
    />
    {{ reports }}
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
// import { Context } from '@nuxt/types'
import { ReportStore } from '@/store'

  @Component({})
export default class Index extends Vue {
  get reports (): Object {
    return ReportStore.getReports
  }

  async asyncData (): Promise<void> {
    await ReportStore.loadReports()
  }
}
</script>
