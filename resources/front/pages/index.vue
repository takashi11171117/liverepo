<template>
  <main class="main">
    <div class="columns is-mobile is-multiline">
      <div v-if="reports.data !== undefined" v-for="report in reports.data" class="column is-12-mobile is-6-tablet is-6-desktop">
          <section class="main-content border-radius">
            <template v-if="report.user !== null">
              <UserData :user="report.user"/>
            </template>
            <n-link :to="{name: 'comedy-reports-id', params: {id: report.id}}" :key="report.id" class="box-link">
              <h1>{{ $truncate(report.title, 30) }}</h1>
              <div class="content">
                <div class="review-content">
                  <ReviewStars :report="report"/>
                  <p class="review-text">{{ $truncate(report.content, 80) }}</p>
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
            </n-link>
          </section>
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
  import Pagination from '../components/Pagination';
  import UserData from '../components/front/UserData';
  import ReviewStars from '../components/front/ReviewStars';

  export default{
    watchQuery: ['page', 'per_page'],
    components: {
      Pagination,
      UserData,
      ReviewStars,
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
<style lang="sass" scoped>
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

  .postedData>div
    margin-bottom: 5px

  .box-link
    display: block
    color: #000

  .content
    display: flex
</style>