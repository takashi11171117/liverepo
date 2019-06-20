<template>
    <main class="main">
        <article class="main-content border-radius">
            <template v-if="isData">
                <div class="is-clearfix user-data">
                    <div class=user-icon>
                        <img src="images/download.jpg"  class=border-radius alt="user icon">
                    </div>
                    <div class=user-name>By {{ data.user.name }}</div>
                    <div class=user-profile>30代 / 女性 / 大阪府</div>
                </div>
                <div class="clearfix postedData">
                    <h1>{{ data.title }}</h1>
                    <div class="is-clearfix category">
                        <ul class="tags">
                            <li>ヤング</li>
                            <li>漫才</li>
                        </ul>
                    </div>
                    <div class="is-clearfix live-data">
                        <ul>
                            <li>ライブ名： ヤングのパタパタ漫才</li>
                            <li>ライブ日時： 18:40</li>
                        </ul>
                    </div>
                    <div class="is-clearfix review-star">
                        <div class="review-star">
                            <div class="star-rating">
                                <div class="star-rating-front" :style="'width: ' + data.rating/5*100 + '%'">★★★★★</div>
                                <div class="star-rating-back">★★★★★</div>
                            </div>
                            <div class="star-number">{{ data.rating }}</div>
                        </div>
                        <div class="posted-date">1days ago</div>
                    </div>
                    <div class="is-clearfix like">
                        <div class="like-button"><i class="far fa-thumbs-up"></i></div>
                        <div class="like-number">380</div>
                    </div>

                    <hr class="dropdown-divider">

                    <div class="is-clearfix" id="image-list" v-if="data.report_images !== null && data.report_images.length > 0">
                        <ul>
                            <li v-for="(report_image, index) in data.report_images">
                                <div class="thumb-image">
                                    <img @click="openGallery(index)" :src="report_image.thumb" alt="thumbnail" class="thumbnail">
                                </div>
                            </li>
                        </ul>
                    </div>
                    <light-box
                            v-if="data.report_images !== null && data.report_images.length > 0"
                            :images="data.report_images"
                            :show-light-box="false"
                            ref="lightbox"
                    />

                    <hr class="dropdown-divider">

                    <p class="review-text">{{ data.content }}</p>
                </div>
            </template>
        </article>
    </main>
</template>

<script>
  export default {
    data() {
      return {
        data: {},
      }
    },
    async asyncData({$axios, params}) {
      let {data} = await $axios.$get(`/comedy/report/${params.id}`);

      return {data};
    },
    methods: {
      isData() {
        return this.data !== {};
      },
      openGallery(index) {
        this.$refs.lightbox.showImage(index)
      },
    }
  }
</script>

<style lang="sass" scoped>
    .tags
        margin-bottom: 10px
        margin-top: 10px
    .tags li
        display: inline-block
        position: relative
        padding: 0.2em 1.4em
        margin-right: 10px
        background: #fff
        color: #000
        border-top: solid 0.5px #000
        border-left: solid 0.5px #000
        border-bottom: solid 5px #000
        border-right: solid 5px #000
        font-size: 12px
        font-weight: bold
        &:before
            content: " "
            position: absolute
            bottom: -5px
            left: -1px
            width: 0
            height: 0
            border-width: 0 6px 6px 0
            border-style: solid
            border-color: transparent
            border-bottom-color: #FFF
        &:after
            content: " "
            position: absolute
            top: -1px
            right: -5px
            width: 0
            height: 0
            border-width: 0px 6px 6px 0px
            border-style: solid
            border-color: #FFF
            border-bottom-color: transparent
    #image-list img
        float: left
        width: 120px
        height: auto
    .dropdown-divider
        margin-top: 20px
        margin-bottom: 20px
</style>