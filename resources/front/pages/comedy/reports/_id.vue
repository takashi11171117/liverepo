<template>
    <main class="main">
        <article class="main-content border-radius">
            <template v-if="isData">
                <UserData :user="data.user"/>
                <div class="postedData">
                    <h1 id="report-title">{{ data.title }}</h1>
                    <ReviewStars :report="data"/>

                    <div class="category">
                        <ul class="tags">
                            <li>ヤング</li>
                            <li>漫才</li>
                        </ul>
                    </div>

                    <div class="live-data">
                        <ul>
                            <li><span>ライブ名</span>ヤングのパタパタ漫才</li>
                            <li><span>ライブ日時</span>18:40</li>
                        </ul>
                    </div>

                    <div class="like-area">
                        <div class="like-button"><i class="far fa-thumbs-up"></i> 380</div>
                        <div class="favorite-button"><i class="far fa-thumbs-up"></i></div>
                    </div>

                    <hr class="dropdown-divider" />

                    <div id="image-list" v-if="data.report_images !== null && data.report_images.length > 0">
                        <ul>
                            <li v-for="(report_image, index) in data.report_images">
                                <img @click="openGallery(index)" :src="report_image.thumb" alt="thumbnail" class="thumbnail thumb-image">
                            </li>
                        </ul>
                    </div>

                    <div v-if="data.report_images !== null && data.report_images.length > 0">
                        <no-ssr>
                            <light-box
                                    :images="data.report_images"
                                    :show-light-box="false"
                                    ref="lightbox"
                            />
                        </no-ssr>
                    </div>

                    <hr class="dropdown-divider" />

                    <p class="review-text">{{ data.content }}</p>
                </div>
            </template>
        </article>
    </main>
</template>

<script>
  import UserData from '../../../components/front/UserData';
  import ReviewStars from '../../../components/front/ReviewStars';

  export default {
    data() {
      return {
        data: {},
      }
    },
    components: {
      UserData,
      ReviewStars,
    },
    async asyncData({$axios, params}) {
      let {data} = await $axios.$get(`/comedy/reports/${params.id}`);

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
    main
        background-color: #f8d048
        height: auto
        color: #000
        padding: 20px

    .main-content
        background-color: #fff
        border-radius: 8px
        padding: 15px 20px
        h1
            padding: 10px 0 10px 0
            font-size: 20px
            font-weight: bold
            line-height: 1.2

    #report-title
        font-size: 30px
        line-height: 1.2
        margin: 20px 0 0 0

    .user-data
        margin-top: 20px

    .user-name
        padding-right: 10px
        font-weight: bold
        font-size: 16px

    .user-profile
        color: #888
        padding-right: 10px

    .category
        margin-bottom: 20px

    .live-data
        margin-bottom: 30px
        font-size: 14px
        li
            display: inline-block
            padding-right: 10px
        span
            background-color: #F8D047
            padding: 8px 10px
            border-radius: 5px
            color: white
            font-weight: bold
            margin-right: 10px

    .tags
        margin-bottom: 10px
        margin-top: 10px

    .tags li
        display: inline-block
        position: relative
        padding: 0.4em 1.4em
        margin-right: 10px
        background: #fff
        color: #000
        border-top: solid 0.5px #000
        border-left: solid 0.5px #000
        border-bottom: solid 5px #000
        border-right: solid 5px #000
        font-size: 14px
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
            border-width: 0 6px 6px 0
            border-style: solid
            border-color: #FFF
            border-bottom-color: transparent

    .like-area
        background-color: #f0f0f0
        padding: 20px
        div
            display: inline-block
            background-color: #aaaaaa
            color: white
            padding: 12px
            border-radius: 5px;

    #image-list
        display: flex
        img
            width: 120px
            height: auto

    .dropdown-divider
        margin-top: 30px
        margin-bottom: 30px

    .review-text
        margin: 0 10px 20px 20px
        font-size: 18px
        white-space: pre-wrap
        word-wrap: break-word
</style>