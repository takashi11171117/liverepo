<template>
  <section class="main-content">
    <UserData :user="report.user" />
    <n-link :to="{name: 'comedy-reports-id', params: {id: report.id}}" class="box-link">
      <h1>{{ $truncate(report.title, 30) }}</h1>
      <ReviewStars :report="report" />
      <div class="content">
        <div class="review-content">
          <p class="review-text" :class="{isImage: isImages}">
            {{ $truncate(report.content, 80) }}
          </p>
          <ReportImages :images="report.report_images" />
        </div>
      </div>
    </n-link>
  </section>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'
import UserData from '@/components/front/UserData.vue'
import ReviewStars from '@/components/front/ReviewStars.vue'
import ReportImages from '@/components/front/ReportImages.vue'
import Report from '@/src/models/Report'

@Component({
  components: {
    UserData,
    ReviewStars,
    ReportImages
  }
})
export default class ReportIndexCard extends Vue {
  @Prop({ default: {} })
  report!: Report

  isImages = (ctx: Context) => {
    const images = this.report.report_images
    return !ctx.app.$isset(images) || images.length <= 0
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
    font-size: 2rem
    font-weight: bold
    line-height: 1.2

.review-content
    overflow: hidden
    display: flex

.review-text
    padding-right: 10px
    line-height: 150%
    margin-bottom: 10px
    font-size: 1.6rem

.review-text.isImage
  width: 100%

.postedData>div
    margin-bottom: 5px

.box-link
    display: block
    color: #000

.content
    display: flex
</style>
