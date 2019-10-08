<template>
  <section class="main-content">
    <UserData :user="report.user" />
    <n-link :to="{name: 'comedy-reports-id', params: {id: report.id}}" class="box-link">
      <h1>{{ $truncate(report.title, 30) }}</h1>
      <div class="content">
        <div class="review-content" :class="{noneImage: isImages}">
          <ReviewStars :report="report" />
          <p class="review-text">
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
import UserData from '@/components/front/UserData.vue'
import ReviewStars from '@/components/front/ReviewStars.vue'
import ReportImages from '@/components/front/ReportImages.vue'

@Component({
  components: {
    UserData,
    ReviewStars,
    ReportImages
  }
})
export default class ReportIndexCard extends Vue {
  @Prop({ default: {} })
  report!: Object
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

    .review-content
        overflow: hidden
        display: flex
        flex-direction: column

    .review-content.noneImage
        width: 100%

    .review-text
        padding-right: 10px
        line-height: 150%
        margin-bottom: 10px
        font-size: 16px

    .postedData>div
        margin-bottom: 5px

    .box-link
        display: block
        color: #000

    .content
        display: flex
</style>
