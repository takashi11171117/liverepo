<template>
  <section>
    <UserData :user="report.user" />
    <h1>{{ $truncate(report.title, 30) }}</h1>
    <div class="content">
      <div class="review-content">
        <ReviewStars :report="report" />
        <p class="review-text">
          {{ $truncate(report.content, 80) }}
        </p>
      </div>
      <ReportImages :images="report.report_images" />
    </div>
    <div class="dropdown-divider" />
  </section>
</template>
<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import ReportImages from '@/components/front/ReportImages.vue'
import ReviewStars from '@/components/front/ReviewStars.vue'
import UserData from '@/components/front/UserData.vue'

@Component({
  components: {
    ReportImages,
    ReviewStars,
    UserData
  }
})
export default class UserReportCard extends Vue {
  @Prop() report!: Object
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
        width: calc(100% - 120px)
        display: flex
        flex-direction: column

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
