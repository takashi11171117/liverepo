<template>
  <main>
    <article class="main-content border-radius">
      <h1>タグ一覧</h1>
      <div class="category">
        <div v-if="reportTags.length" class="columns">
          <div v-for="(tagColumn, index) in reportTags" :key="index" class="report-tags column is-desktop is-3">
            <div v-for="(tagName, index2) in tagColumn" :key="index2">
              <Tag :tag-name="tagName" />
            </div>
          </div>
        </div>
      </div>
    </article>
  </main>
</template>

<script>
import { Component, Vue } from 'nuxt-property-decorator'
import { ReportTagStore } from '@/store'
import UserData from '@/components/front/UserData.vue'
import ReviewStars from '@/components/front/ReviewStars.vue'
import Tag from '@/components/front/Tag.vue'

@Component({
  components: {
    UserData,
    ReviewStars,
    Tag
  }
})
export default class ReportTags extends Vue {
  get reportTags () {
    return ReportTagStore.getReportTags
  }

  async asyncData () {
    await ReportTagStore.loadReportTags()
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

.report-tags /deep/ a
    display: block
</style>
