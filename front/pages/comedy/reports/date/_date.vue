<template>
  <div class="columns">
    <aside class="column is-narrow-desktop is-narrow-tablet">
      <ReportCalendar />
    </aside>
    <main class="column">
      <section class="main-content border-radius">
        <div v-for="(tag, index) in tags" :key="index">
          <h1 class="live-name">
            {{ tag.name }}
          </h1>
          <div v-for="(report) in tag.reports" :key="report.id" class="column is-12-mobile">
            <UserReportCard :report="report" />
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { nuxtContext } from '@/src/@types'
import { ReportStore, CalendarStore } from '@/store'
import UserReportCard from '@/components/front/UserReportCard.vue'
import ReportCalendar from '@/components/front/ReportCalendar.vue'

@Component({
  components: {
    UserReportCard,
    ReportCalendar
  }
})
export default class ReportDate extends Vue {
  error = {}

  get tags (): Object {
    return ReportStore.getTags
  }

  openGallery (index: number) {
    const ref:any = this.$refs.lightbox
    ref.showImage(index)
  }

  async asyncData (this: void, ctx: nuxtContext) {
    await ReportStore.loadReportsByDate(ctx.params.date)
  }

  async fetch () {
    const today = new Date()
    const month = ('0' + (today.getMonth() + 1)).slice(-2)
    await CalendarStore.fetchAttributes(`${today.getFullYear()}-${month}`)
  }
}
</script>

<style lang="sass" scoped>
.main-content
    background-color: #fff
    border-radius: 8px
    padding: 15px 20px
h1
    padding: 10px 0 10px 0
    font-size: 20px
    font-weight: bold
    line-height: 1.2

#report-title
    font-size: 30px
    line-height: 1.2
    margin: 20px 0 0 0

.user-data
    margin-top: 20px

.user-name
    padding-right: 10px
    font-weight: bold
    font-size: 16px

.user-profile
    color: #888
    padding-right: 10px

.category
    margin-bottom: 20px

.live-data
    margin-bottom: 30px
    font-size: 14px
    li
        display: inline-block
        padding-right: 10px
    span
        background-color: #F8D047
        padding: 8px 10px
        border-radius: 5px
        color: white
        font-weight: bold
        margin-right: 10px

.tags
    margin-bottom: 10px
    margin-top: 10px

.like-area
    background-color: #f0f0f0
    padding: 20px

#image-list
    display: flex
    img
        width: 120px
        height: auto

.dropdown-divider
    margin-top: 30px
    margin-bottom: 30px

.review-text
    margin-top: 10px
    font-size: 18px
    white-space: pre-wrap
    word-wrap: break-word

.live-name
    border-bottom: 3px solid #e2e2e2
</style>
