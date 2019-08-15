<template>
    <section class="main-content">
        <UserData :user="report.user"/>
        <n-link :to="{name: 'comedy-reports-id', params: {id: report.id}}" :key="report.id" class="box-link">
            <h1>{{ $truncate(report.title, 30) }}</h1>
            <div class="content">
                <div class="review-content" v-bind:class="{noneImage: isImages}">
                    <ReviewStars :report="report"/>
                    <p class="review-text">{{ $truncate(report.content, 80) }}</p>
                </div>
                <ReportImages :images="report.report_images"/>
            </div>
        </n-link>
    </section>
</template>

<script>
  import UserData from './UserData';
  import ReviewStars from './ReviewStars';
  import ReportImages from './ReportImages';

  export default {
    components: {
      UserData,
      ReviewStars,
      ReportImages,
    },
    props: {
      report: Object,
    },
    methods: {
      isImages() {
        let images = this.report.report_images;
        return !this.$isset(images) || images.length <= 0;
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