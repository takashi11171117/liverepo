<template>
  <div class="section">
    <div class="form">
      <h1>レポート投稿</h1>
      <TextInput
        :value="form.title"
        label="タイトル"
        name="title"
        placeholder="タイトルを入力"
        :error="form.error"
        @input="onInput('title', $event)"
      />

      <TextInput
        :value="form.content"
        label="本文"
        name="content"
        placeholder="本文を入力"
        :error="form.error"
        type="textarea"
        @input="onInput('content', $event)"
      />

      <SelectInput
        :value="form.status"
        label="ステータス"
        name="status"
        :error="form.error"
        :options="$data.reportStatus"
        @input="onInput('status', $event)"
      />

      <SelectInput
        :value="form.rating"
        label="評価"
        name="rating"
        :error="form.error"
        :options="$data.reportRating"
        @input="onInput('rating', $event)"
      />

      <TagifyInput
        label="開催場所"
        name="place_tags"
        :error="form.error"
        :report_tags="place_tags"
        :on-update="newTags => {
          onInput('place_tags', newTags)
        }"
      />

      <TagifyInput
        label="出演者"
        name="player_tags"
        :error="form.error"
        :report_tags="player_tags"
        :on-update="newTags => {
          onInput('player_tags', newTags)
        }"
      />

      <TagifyInput
        label="タグ"
        name="other_tags"
        :error="form.error"
        :report_tags="other_tags"
        :on-update="newTags => {
          onInput('other_tags', newTags)
        }"
      />

      <DateInput
        :value="form.opened_at"
        label="開催日時"
        name="opened_at"
        :error="form.error"
        @input="onInput('opened_at', $event)"
      />

      <ImageInput
        :value="form.file"
        label="画像1"
        name="images.0"
        :error="form.error"
        @input="onInput('file', $event)"
      />

      <div class="buttons">
        <button id="submit" class="button is-primary" @click="onSubmit()">
          保存する
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import moment from 'moment'
import { ReportStore, FrontReportPostStore } from '@/store'
import TextInput from '@/components/form/TextInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import ImageInput from '@/components/form/ImageInput.vue'
import DateInput from '@/components/form/DateInput.vue'
import TagifyInput from '@/components/form/TagifyInput.vue'

@Component({
  components: {
    TextInput,
    ImageInput,
    SelectInput,
    DateInput,
    TagifyInput
  },
  middleware: [
    'redirectIfGuest'
  ]
})
export default class SettingPost extends Vue {
  get form () {
    return FrontReportPostStore.getForm
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

  mounted () {
    const report = ReportStore.getReport
    const args: { [key: string]: any } = {};
    ['place', 'player', 'other'].forEach((taxonomy) => {
      args[`${taxonomy}_tags`] = this.initTags(report, taxonomy)
    })
    FrontReportPostStore.updateForm(args)
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
    FrontReportPostStore.updateInput({ [name]: event })
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

  async onSubmit () {
    if (confirm('追加してもよろしいですか？')) {
      await this.addReport(
        {
          title: this.form.title,
          content: this.form.content,
          status: this.form.status,
          rating: this.form.rating,
          file: this.form.file,
          opened_at: moment(this.form.opened_at).format('YYYY-MM-DD HH:mm:ss'),
          place_tags: JSON.stringify(this.form.place_tags),
          player_tags: JSON.stringify(this.form.player_tags),
          other_tags: JSON.stringify(this.form.other_tags)
        }
      ).catch((err: any) => {
        FrontReportPostStore.updateFormError(err.response.data.errors)
      })

      if (Object.keys(this.form.error).length !== 0) {
        return
      }

      FrontReportPostStore.updateForm({
        title: '',
        content: '',
        status: '',
        rating: '',
        report_images: [],
        place_tags: [],
        player_tags: [],
        other_tags: [],
        file: null,
        opened_at: null,
        error: {}
      })
      Snackbar.open({
        duration: 5000,
        message: 'レポートを追加しました。',
        type: 'is-success'
      });
      (this as any).$router.push('/')
    }
  }

  async addReport (params) {
    const formData = new FormData()
    if ((this as any).$isset(params.file)) {
      const blob = await this.$imageCompress(params.file)
      const compressedFile = new File([blob], params.file.name, {
        type: params.file.type
      })
      formData.append('images[]', compressedFile)
    }
    formData.append('title', params.title)
    formData.append('content', params.content)
    formData.append('status', params.status)
    formData.append('rating', params.rating)
    formData.append('opened_at', params.opened_at)
    formData.append('place_tags', params.place_tags)
    formData.append('player_tags', params.player_tags)
    formData.append('other_tags', params.other_tags)
    await ReportStore.addReport({ form: formData })
  }
}
</script>

<style scoped lang="sass">
.form
    margin-left: 20px
    margin-right: 20px
h1
    font-size: 28px
    font-weight: bold
    margin-bottom: 20px

.section
    background-color: #fff
    border-radius: 10px
</style>
