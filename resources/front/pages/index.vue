<template>
  <main class="main">
    <div class="columns is-mobile is-multiline">
      <div v-if="reports.data !== undefined" v-for="(report, key) in reports.data" class="column is-12-mobile is-6-tablet is-6-desktop">
        <section class="main-content border-radius">
          <div class="is-clearfix user-data">
            <div class=user-icon>
              <!--<img src="images/download.jpg"  class=border-radius alt="user icon">-->
            </div>
            <div class=user-name>By user name</div>
            <div class=user-profile>age / gender / states</div>
          </div>
          <h1>{{ $truncate(report.title, 30) }}</h1>
          <div class="is-clearfix">
            <img v-if="report.report_images.length > 0" :src="`${$data.image_url}report_images/thumb-${report.report_images[0].path}`" alt="thumbnail" class="thumbnail">
            <img v-if="report.report_images.length === 0" src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
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
      </div>
    </div>
    <Pagination
            current_path="/"
            v-bind:pagination="reports"
            v-if="Object.keys(reports).length > 0"
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
      const reports = await $axios.$get('http://localhost:8000', {
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
    padding: 10px 15px
    h1
      padding: 5px 0 10px 0
      font-size: 18px
      font-weight: bold

  .user-data div
    float: left
    line-height: 30px
    font-size: 14px

  .thumbnail
    float: right
    width: 120px

  .user-icon
    width: 30px
    height: 30px
    img
      border-radius: 5px

  .review-content
    overflow: hidden
    width: calc(100% - 140px)
    display: flex
    flex-direction: column

  .review-star
    padding-bottom: 5px
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
    margin-left: 10px
    margin-bottom: 5px

  .review-text
    padding-right: 10px
    line-height: 150%
    margin-bottom: 10px
    font-size: 14px

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
</style>