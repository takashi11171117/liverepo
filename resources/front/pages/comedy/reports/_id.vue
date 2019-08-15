<template>
    <div class="columns">
        <aside class="column is-narrow-desktop is-narrow-tablet">
            <no-ssr>
                <vc-calendar></vc-calendar>
            </no-ssr>
        </aside>
        <main class="column">
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

                        <hr class="dropdown-divider"/>

                        <template v-if="$isset(data.report_images) && data.report_images.length > 0">
                            <div id="image-list">
                                <ul>
                                    <li v-for="(report_image, index) in data.report_images">
                                        <img @click="openGallery(index)" :src="report_image.thumb" alt="thumbnail"
                                             class="thumbnail thumb-image">
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <no-ssr>
                                    <light-box
                                            :images="data.report_images"
                                            :show-light-box="false"
                                            ref="lightbox"
                                    />
                                </no-ssr>
                            </div>
                            <hr class="dropdown-divider"/>
                        </template>

                        <p class="review-text">{{ data.content }}</p>
                    </div>
                </template>
            </article>
            <div class="comment main-content border-radius">
                <h1>コメント一覧</h1>
                <template v-for="comment in data.report_comments">
                    <div class="comment-box">
                        <div class="comment-header">
                            <UserData :user="comment.user"/>
                            <p class="created_at">{{ comment.created_at }}</p>
                        </div>
                        <p>{{ comment.body }}}</p>
                        <hr class="dropdown-divider"/>
                    </div>
                </template>
                <div class="comment-post">
                    <div class="comment-post-header">
                        <h1>コメントを投稿する</h1>
                        <template v-if="$auth.$state.loggedIn">
                            <UserData :user="$auth.user"/>
                        </template>
                    </div>
                    <TextInput
                            name="body"
                            v-model="body"
                            placeholder="コメントを入力"
                            :error="error"
                            type="textarea"
                    />

                    <div class="buttons">
                        <button id="submit" @click="onComment()" class="button is-primary">コメントする</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
  import UserData from '../../../components/front/UserData';
  import ReviewStars from '../../../components/front/ReviewStars';
  import Follow from '../../../components/Follow';
  import Tag from '../../../components/front/Tag';
  import TextInput from '../../../components/TextInput';

  export default {
    data() {
      return {
        data: {},
        currentFollowing: false,
        currentCountFollowers: 0,
        body: '',
        error: {}
      }
    },
    components: {
      UserData,
      ReviewStars,
      Follow,
      Tag,
      TextInput
    },
    async asyncData({$axios, params, app}) {
      let {data} = await $axios.$get(`/comedy/reports/${params.id}`);

      let currentFollowing = false;
      if (app.$auth.$state.loggedIn) {
        const tempFollow = await $axios.$get(`/follow_reports/${data.id}`);
        currentFollowing = tempFollow.result
      }

      let currentCountFollowers = data.followers_count;
      if (currentFollowing) {
        currentCountFollowers -= 1;
      }

      return {data, currentCountFollowers, currentFollowing};
    },
    methods: {
      isData() {
        return this.data !== {};
      },
      openGallery(index) {
        this.$refs.lightbox.showImage(index)
      },
      async onComment() {
        if (!this.$auth.$state.loggedIn) {
          this.$router.replace({
            name: 'auth-login'
          });
          return
        }
        if (confirm('コメントしますか？')) {
          await this.$axios.$post(
            'report_comments',
            {
              body: this.body,
              report_id: this.data.id
            }
          ).then(() => {
            this.$snackbar.open({
              duration: 5000,
              message: 'コメントを追加しました。',
              type: 'is-success',
            });
          }).catch((error) => {
            console.log(error);
            this.$set(this, 'error', error.response.data.errors);
          })
        }
      },
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
        margin-top: 10px
        font-size: 18px
        white-space: pre-wrap
        word-wrap: break-word

    .comment
        margin-top: 30px

    .created_at
        color: #333
        font-size: 14px

    .comment-header
        display: flex
        align-items: center
        .created_at
            padding-top: 3px
            margin-left: auto

    .comment-post-header
        display: flex
        align-items: center
        h1
            padding-top: 14px
            padding-right: 20px
</style>