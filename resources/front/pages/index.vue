<template>
  <main class="main">
    <div class="columns is-mobile is-multiline">
      <div v-if="reports.data !== undefined" v-for="(report) in reports.data" class="column is-12-mobile is-6-tablet is-6-desktop">
        <n-link :to="{name: 'comedy-report-id', params: {id: report.id}}" :key="report.id" class="box-link">
          <section class="main-content border-radius">
            <div class="is-clearfix user-data">
              <div class=user-icon>
                <template v-if="report.user.thumb !== undefined">
                  <img :src="report.user.thumb">
                </template>
                <template v-else>
                  <img src="~assets/none_image.jpg">
                </template>
              </div>
              <div class=user-name>By {{ report.user.name }}</div>
              <div class=user-profile>{{ $calcAge(report.user.birth) }} / {{ $data.genderOption[report.user.gender] }} / states</div>
            </div>
            <h1>{{ $truncate(report.title, 30) }}</h1>
            <div class="is-clearfix">
              <img v-if="report.report_images !== undefined && report.report_images.length > 0" :src="report.report_images[0].path" alt="thumbnail" class="thumbnail">
              <img v-if="report.report_images !== undefined && report.report_images.length === 0" src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
              <div class="clearfix review-content">
                <div class="review-star">
                  <div class="star-rating">
                    <div class="star-rating-front" :style="'width: ' + report.rating/5*100 + '%'">★★★★★</div>
                    <div class="star-rating-back">★★★★★</div>
                  </div>
                  <div class="star-number">{{ report.rating }}</div>
                </div>
                <p class="review-text">{{ $truncate(report.content, 80) }}</p>
              </div>
            </div>
          </section>
        </n-link>
      </div>
    </div>
    <Pagination
            current_path="/"
            v-bind:pagination="reports"
            v-if="reports.data !== undefined && Object.keys(reports.data).length > 0"
    />
  </main>
</template>
<script>
  import Pagination from '../components/admin/Pagination'

  export default{
    watchQuery: ['page', 'per_page'],
    components: {
      Pagination,
    },
    data() {
      return {
        reports: {},
      }
    },
    async asyncData({$axios, query}){
      const reports = await $axios.$get('/', {
        params: {
          page: query.page,
          per_page: query.per_page,
        }
      });
      return {reports};
    }
  }
</script>
<style lang="sass">
  main
    background-color: #f8d048
    height: auto
    color: #000
    padding-top: 20px
    padding-bottom: 20px
    padding-left: 20px
    padding-right: 20px

  .main-content
    background-color: #fff
    border-radius: 8px
    padding: 15px 20px
    h1
      padding: 10px 0 10px 0
      font-size: 20px
      font-weight: bold
      line-height: 1.2

  .user-data div
    float: left
    line-height: 30px
    font-size: 14px
    margin-bottom: 15px

  .thumbnail
    float: right
    width: 120px

  .user-icon
    width: 30px
    height: 30px
    margin-right: 10px
    img
      border-radius: 5px

  .user-name
    margin-right: 10px
    font-weight: bold

  .user-profile
    color: #888

  .review-content
    overflow: hidden
    width: calc(100% - 120px)
    display: flex
    flex-direction: column

  .review-star
    padding-bottom: 15px
    display: flex

  .star
    display: inline-block
    font-size: 14px
    font-weight: bold
    color: #f8d048

  .star-number
    font-size: 14px
    font-weight: bold
    color: #000
    margin-left: 5px
    display: flex
    align-items: center

  .postedData>div
    margin-bottom: 5px

  .review-text
    padding-right: 10px
    line-height: 150%
    margin-bottom: 10px
    font-size: 16px

  .star-rating
    position: relative
    width: 5em
    height: 1em
    font-size: 20px
    display: flex
    align-items: center

  .star-rating-front
    position: absolute
    top: 0
    left: 0
    overflow: hidden
    color: #ffcc33

  .star-rating-back
    color: #ccc

  .box-link
    display: block
    color: #000

</style>