<template>
  <main class="main">
    <div class="columns is-mobile is-multiline">
      <div v-for="item in data.data" class="column is-12-mobile is-6-tablet is-6-desktop">
        <section class="main-content border-radius">
          <div class="is-clearfix user-data">
            <div class=user-icon>
              <!--<img src="images/download.jpg"  class=border-radius alt="user icon">-->
            </div>
            <div class=user-name>By user name</div>
            <div class=user-profile>age / gender / states</div>
          </div>
          <h1>{{ $truncate(item.title, 30) }}</h1>
          <div class="is-clearfix">
            <img src="http://placehold.jp/120x120.png" alt="thumbnail" class="thumbnail">
            <div class="clearfix review-content">
              <div class="review-star">
                <div class="star">★★★★★</div>
                <div class="star-number">rating</div>
              </div>
              <p class="review-text">{{ $truncate(item.content, 80) }}</p>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>
</template>
<script>
  export default{
    async asyncData({$axios}){
      const data = await $axios.$get('/');
      return {data};
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

  .star
    display: inline-block
    font-size: 14px
    font-weight: bold
    color: #f8d048

  .star-number
    display: inline-block
    font-size: 14px
    font-weight: bold
    color: #000
    margin-left: 5px
    margin-bottom: 5px

  .postedData>div
    margin-left: 10px
    margin-bottom: 5px

  .review-text
    padding-right: 10px
    line-height: 150%
    margin-bottom: 10px
    font-size: 14px
</style>