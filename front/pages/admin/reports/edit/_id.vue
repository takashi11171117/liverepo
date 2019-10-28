<template>
  <section class="container">
    <h1 class="title">
      レポート編集
    </h1>
    <TextInput
      label="タイトル"
      name="title"
      :value="form.title"
      placeholder="タイトル"
      :error="form.error"
      @input="onInput('title', $event)"
    />

    <TextInput
      label="本文"
      name="content"
      :value="form.content"
      placeholder="本文"
      :error="form.error"
      type="textarea"
      @input="onInput('content', $event)"
    />

    <SelectInput
      label="ステータス"
      name="status"
      :value="form.status"
      :error="form.error"
      :options="$data.reportStatus"
      @input="onInput('status', $event)"
    />

    <SelectInput
      label="評価"
      name="rating"
      :value="form.rating"
      :error="form.error"
      :options="$data.reportRating"
      @input="onInput('rating', $event)"
    />

    <TagifyInput
      name="place_tags"
      label="開催場所"
      :error="form.error"
      :report_tags="place_tags"
      :on-update="newTags => {
        onInput('place_tags', newTags)
      }"
    />

    <TagifyInput
      name="player_tags"
      label="出演者"
      :error="form.error"
      :report_tags="player_tags"
      :on-update="newTags => {
        onInput('player_tags', newTags)
      }"
    />

    <TagifyInput
      name="other_tags"
      label="その他タグ"
      :error="form.error"
      :report_tags="other_tags"
      :on-update="newTags => {
        onInput('other_tags', newTags)
      }"
    />

    <div v-if="form.report_images !== null && form.report_images.length > 0" id="image-list">
      <p class="label">
        画像一覧
      </p>
      <ul>
        <li v-for="(report_image, index) in form.report_images" :key="index">
          <div class="thumb-image">
            <img :src="report_image.src" alt="thumbnail" class="thumbnail" @click="openGallery(index)">
          </div>
        </li>
      </ul>
    </div>

    <light-box
      v-if="form.report_images !== null && form.report_images.length > 0"
      ref="lightbox"
      :images="form.report_images"
      :show-light-box="false"
    />

    <ImageInput
      :value="form.file"
      label="画像1"
      name="images.0"
      :error="form.error"
      @input="onInput('file', $event)"
    />

    <div class="buttons">
      <button id="submit" class="button is-primary" @click="updateEachData()">
        保存する
      </button>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import { nuxtContext } from '@/src/@types'
import { ReportStore, ReportEditStore } from '@/store'
import TextInput from '@/components/form/TextInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import TagifyInput from '@/components/form/TagifyInput.vue'
import Tagify from '@/components/form/Tagify.vue'
import ImageInput from '@/components/form/ImageInput.vue'

@Component({
  components: {
    Tagify,
    TextInput,
    TagifyInput,
    SelectInput,
    ImageInput
  },
  layout: 'admin',
  middleware: ['redirectIfAdminGuest']
})
export default class Admin extends Vue {
  openGallery (index: number) {
    const ref:any = this.$refs.lightbox
    ref.showImage(index)
  }

  get form () {
    return ReportEditStore.getForm
  }

  get place_tags () {
    return this.getTags('place')
  }

  get player_tags () {
    return this.getTags('player')
  }

  get other_tags () {
    return this.getTags('other')
  }

  getTags (taxonomy: string): Array<any> {
    const report = ReportStore.getReport
    if (report.report_tags) {
      return report.report_tags
        .filter((tag) => {
          return tag.taxonomy === taxonomy
        })
        .map((tag) => {
          return { text: tag.name }
        })
    }

    return []
  }

  async fetch (ctx: nuxtContext): Promise<void> {
    await ReportStore.loadReport({ id: ctx.params.id, auth: 'admin' })
    const report = ReportStore.getReport
      type formArgs = {
        title: string
        content: string
        status: string
        rating: string
        report_images: { path: string }[],
        place_tags: Array<string>,
        player_tags: Array<string>,
        other_tags: Array<string>
      }

      const args: formArgs = {
        title: report.title,
        content: report.content,
        status: `${report.status}`,
        rating: `${report.rating}`,
        report_images: report.report_images,
        place_tags: [],
        player_tags: [],
        other_tags: []
      }

      ReportEditStore.updateForm(args)
  }

  mounted () {
    const report = ReportStore.getReport
    const args: { [key: string]: any } = {};
    ['place', 'player', 'other'].forEach((taxonomy) => {
      args[`${taxonomy}_tags`] = this.initTags(report, taxonomy)
    })
    ReportEditStore.updateForm(args)
  }

  initTags (report: {report_tags: Array<any>}, taxonomy: string): Array<any> {
    return report.report_tags
      .filter((tag) => {
        return tag.taxonomy === taxonomy
      })
      .map((tag) => {
        return tag.name
      })
  }

  onInput (name: string, event: any) {
    ReportEditStore.updateInput({ [name]: event })
  }

  async updateEachData () {
    if (confirm('更新してもよろしいですか？')) {
      const formData = new FormData()
      formData.append('_method', 'PUT')
      formData.append('title', this.form.title)
      formData.append('content', this.form.content)
      formData.append('status', this.form.status)
      formData.append('rating', this.form.rating)
      formData.append('place_tags', JSON.stringify(this.form.place_tags))
      formData.append('player_tags', JSON.stringify(this.form.player_tags))
      formData.append('other_tags', JSON.stringify(this.form.other_tags))
      if (this.form.file !== undefined && this.form.file !== null) {
        formData.append('images[]', this.form.file)
      }
      const response = await ReportStore.updateReport({ id: (this as any).$route.params.id, form: formData, auth: 'admin' })
        .catch((err: any) => {
          ReportEditStore.updateFormError(err.response.data.errors)
          return { err }
        })

      if (response && response.err) {
        return
      }

      await ReportStore.loadReport({ id: (this as any).$route.params.id, auth: 'admin' })
      const report = ReportStore.getReport
      ReportEditStore.updateForm({
        title: report.title,
        content: report.content,
        status: report.status,
        rating: report.rating,
        file: report.file,
        report_images: report.report_images
      })
      Snackbar.open({
        duration: 5000,
        message: 'レポートを更新しました。',
        type: 'is-success'
      })
    }
  }
}
</script>

<style scoped lang="sass">
  #tagify
    margin-bottom: 20px
  #image-list
    margin-bottom: 20px
    ul
      display: flex
      margin-left: -10px
      margin-right: -10px
      li
        padding-left: 10px
        padding-right: 10px
    .thumb-image
      position: relative
      > img
        width: 120px
        height: 120px
        object-fit: cover
  .field
    flex-direction: column
    img
      width: 80px
      height: 80px
      object-fit: cover;
  .file-button
    display: flex
    margin-bottom: 10px
</style>
