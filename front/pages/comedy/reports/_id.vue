<template>
  <div class="columns">
    <aside class="column is-narrow-desktop is-narrow-tablet">
      <ReportCalendar />
    </aside>
    <main class="column">
      <article class="main-content border-radius">
        <template>
          <UserData :user="report.user" />
          <div class="postedData">
            <h1 id="report-title">
              {{ report.title }}
            </h1>
            <ReviewStars :report="report" />

            <div class="category">
              <div v-for="(tagName, index) in report.report_tags" :key="index">
                <Tag :tag-name="tagName" />
              </div>
            </div>

            <div class="live-data">
              <ul>
                <li><span>ライブ名</span>ヤングのパタパタ漫才</li>
                <li><span>ライブ日時</span>18:40</li>
              </ul>
            </div>

            <div class="like-area">
              <Follow
                :each-data="report"
                :current-following="currentFollowing"
                follow-type="follow_reports"
              >
                <template v-slot:follow>
                  <i class="fas fa-check" />&nbsp;{{ parseInt(currentCountFollowers, 10) + 1 }}
                </template>
                <template v-slot:unfollow>
                  <i class="far fa-thumbs-up" />&nbsp;{{ currentCountFollowers }}
                </template>
              </Follow>
            </div>

            <hr class="dropdown-divider">

            <template v-if="$isset(report.report_images) && report.report_images.length > 0">
              <div id="image-list">
                <ul>
                  <li v-for="(report_image, index) in report.report_images" :key="index">
                    <img
                      :src="report_image.thumb"
                      alt="thumbnail"
                      class="thumbnail thumb-image"
                      @click="openGallery(index)"
                    >
                  </li>
                </ul>
              </div>
              <div>
                <no-ssr>
                  <light-box
                    ref="lightbox"
                    :images="report.report_images"
                    :show-light-box="false"
                  />
                </no-ssr>
              </div>
              <hr class="dropdown-divider">
            </template>

            <p class="review-text">
              {{ report.content }}
            </p>
          </div>
        </template>
      </article>
      <div class="comment main-content border-radius">
        <h1>コメント一覧</h1>
        <div v-for="comment in report.report_comments" :key="comment.id" class="comment-box">
          <div class="comment-header">
            <UserData :user="comment.user" />
            <p class="created_at">
              {{ comment.created_at }}
            </p>
          </div>
          <p>{{ comment.body }}}</p>
          <hr class="dropdown-divider">
        </div>
        <div class="comment-post">
          <div class="comment-post-header">
            <h1>コメントを投稿する</h1>
            <template v-if="$auth.$state.loggedIn">
              <UserData :user="$auth.user" />
            </template>
          </div>
          <TextInput
            v-model="body"
            name="body"
            placeholder="コメントを入力"
            :error="error"
            type="textarea"
          />

          <div class="buttons">
            <button id="submit" class="button is-primary" @click="onComment()">
              コメントする
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import { nuxtContext } from '@/src/@types'
import { ReportStore, FollowReportStore, ReportCommentStore } from '@/store'
import ReportCalendar from '@/components/front/ReportCalendar.vue'
import UserData from '@/components/front/UserData.vue'
import ReviewStars from '@/components/front/ReviewStars.vue'
import Follow from '@/components/front/Follow.vue'
import Tag from '@/components/front/Tag.vue'
import TextInput from '@/components/form/TextInput.vue'
import ReportModel from '@/src/models/Report'

@Component({
  components: {
    UserData,
    ReviewStars,
    Follow,
    Tag,
    TextInput,
    ReportCalendar
  }
})
export default class Report extends Vue {
  body = ''
  error = {}

  get report (): ReportModel {
    return ReportStore.getReport
  }

  get currentFollowing () {
    return FollowReportStore.getFollowReports
  }

  get currentCountFollowers () {
    let countFollowers = this.report.followers_count
    if (this.currentFollowing) {
      countFollowers -= 1
    }

    return countFollowers
  }

  async fetch (this: void, ctx: nuxtContext): Promise<void> {
    await ReportStore.loadReport({ id: parseInt(ctx.params.id), auth: '' })
    await FollowReportStore.loadFollowReports(parseInt(ctx.params.id))
  }

  openGallery (index: number) {
    const ref:any = this.$refs.lightbox
    ref.showImage(index)
  }

  async onComment () {
    const _this = (this as any)
    if (!_this.$auth.$state.loggedIn) {
      _this.$router.replace({
        name: 'auth-login'
      })
      return
    }
    if (confirm('コメントしますか？')) {
      await ReportCommentStore.updateReportComment(
        this.body, this.report.id
      ).then(() => {
        Snackbar.open({
          duration: 5000,
          message: 'コメントを追加しました。',
          type: 'is-success'
        })
      }).catch((error: any) => {
        this.$set(this, 'error', error.response.data.errors)
      })
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
