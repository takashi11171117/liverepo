<template>
  <main class="main">
    <div class="columns is-multiline">
      <div class="column is-narrow-desktop is-narrow-tablet side-content">
        <section class="main-content">
          <h1>{{ reportTag.name }}</h1>
          <Follow
            :each-data="reportTag"
            :current-following="currentFollowing"
            follow-type="follow_report_tags"
          />
        </section>
      </div>
      <div class="column">
        <section class="main-content border-radius report">
          <hr class="dropdown-divider">
          <template v-if="reports.data.length">
            <section v-for="report in reports.data" :key="report.id" class="column is-12-mobile">
              <UserData :user="report.user" />
              <h1>{{ $truncate(report.title, 30) }}</h1>
              <div class="content">
                <div class="review-content">
                  <ReviewStars :report="report" />
                  <p class="review-text">
                    {{ $truncate(report.content, 80) }}
                  </p>
                </div>
                <template v-if="report.report_images !== undefined && report.report_images.length > 0">
                  <div class="thumbnail-box">
                    <img :src="report.report_images[0].path" alt="thumbnail" class="thumbnail">
                  </div>
                </template>
                <template v-else>
                  <img src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
                </template>
              </div>
              <div class="dropdown-divider" />
            </section>
            <Pagination
              v-if="reports.data !== undefined && Object.keys(reports.data).length > 0"
              :current_path="`/comedy/report_tags/${encodeURI(reportTag.name)}`"
              :pagination="reports.meta"
            />
          </template>
          <template v-else>
            <p>まだ投稿はありません。</p>
          </template>
        </section>
      </div>
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { nuxtContext } from '@/src/@types'
import { ReportTagStore, FollowReportTagStore, ReportStore } from '@/store'
import Pagination from '@/components/Pagination.vue'
import UserData from '@/components/front/UserData.vue'
import ReviewStars from '@/components/front/ReviewStars.vue'
import Follow from '@/components/front/Follow.vue'

@Component({
  components: {
    Pagination,
    UserData,
    ReviewStars,
    Follow
  },
  watchQuery: ['page']
})
export default class ReportTag extends Vue {
  get reportTag (): Object {
    return ReportTagStore.getReportTag
  }

  get currentFollowing (): boolean {
    return FollowReportTagStore.getFollowReportTags
  }

  get reports (): Object {
    return ReportStore.getReports
  }

  async asyncData (this: void, ctx: nuxtContext): Promise<void> {
    try {
      const reportTagId = await ReportTagStore.loadReportTag(ctx.params.name)
      await FollowReportTagStore.loadFollowReportTags(reportTagId)
      await ReportStore.loadReportsByReportTag(ctx.params.name)
    } catch (e) {
      // eslint-disable-next-line
      console.log(e)
    }
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

.thumbnail-box
    width: 120px

.content
    display: flex

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
</style>
