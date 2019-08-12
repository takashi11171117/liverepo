<template>
    <main class="main">
        <article class="main-content border-radius">
            <template v-if="isData">
                <UserData :user="data.user"/>
                <div class="postedData">
                    <h1 id="report-title">{{ data.title }}</h1>
                    <ReviewStars :report="data"/>

                    <div class="category">
                        <template v-for="tagName in data.report_tags">
                            <Tag :tagName="tagName"/>
                        </template>
                    </div>

                    <div class="live-data">
                        <ul>
                            <li><span>ライブ名</span>ヤングのパタパタ漫才</li>
                            <li><span>ライブ日時</span>18:40</li>
                        </ul>
                    </div>

                    <div class="like-area">
                        <Follow
                                :eachData="data"
                                :currentFollowing="currentFollowing"
                                followType="follow_reports"
                        >
                            <template v-slot:follow>
                                <i class="fas fa-check"></i>&nbsp;{{ parseInt(currentCountFollowers, 10) + 1 }}
                            </template>
                            <template v-slot:unfollow>
                                <i class="far fa-thumbs-up"></i>&nbsp;{{ currentCountFollowers }}
                            </template>
                        </Follow>
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
  import Follow from '../../../components/Follow';
  import Tag from '../../../components/front/Tag';

  export default {
    data() {
      return {
        data: {},
        currentFollowing: false,
        currentCountFollowers: 0,
      }
    },
    components: {
      UserData,
      ReviewStars,
      Follow,
      Tag
    },
    async asyncData({$axios, params, app}) {
      let {data} = await $axios.$get(`/comedy/reports/${params.id}`);

      let currentFollowing = false;
      if (app.$auth.$state.loggedIn) {
        const tempFollow = await $axios.$get(`/follow_reports/${data.id}`);
        currentFollowing = tempFollow.result
      }

      let currentCountFollowers = data.followers_count;
      if(currentFollowing) {
        currentCountFollowers -= 1;
      }

      return {data, currentCountFollowers};
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

    .like-area
        background-color: #f0f0f0
        padding: 20px

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