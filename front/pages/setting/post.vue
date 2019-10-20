<template>
  <div class="section">
    <div class="form">
      <h1>レポート投稿</h1>
      <TextInput
        v-model="title"
        label="タイトル"
        name="title"
        placeholder="タイトルを入力"
        :error="error"
      />

      <TextInput
        v-model="content"
        label="本文"
        name="content"
        placeholder="本文を入力"
        :error="error"
        type="textarea"
      />

      <SelectInput
        v-model="status"
        label="ステータス"
        name="status"
        :error="error"
        :options="$data.reportStatus"
      />

      <SelectInput
        v-model="rating"
        label="評価"
        name="rating"
        :error="error"
        :options="$data.reportRating"
      />

      <TagifyInput
        label="開催場所"
        name="place_tags"
        :error="error"
        :report_tags="place_tags"
        :on-update="newTags => place_tags = newTags"
      />

      <TagifyInput
        label="出演者"
        name="player_tags"
        :error="error"
        :report_tags="player_tags"
        :on-update="newTags => player_tags = newTags"
      />

      <TagifyInput
        label="タグ"
        name="other_tags"
        :error="error"
        :report_tags="other_tags"
        :on-update="newTags => other_tags = newTags"
      />

      <DateInput
        v-model="opened_at"
        label="開催日時"
        name="opened_at"
        :error="error"
      />

      <ImageInput
        v-model="file"
        label="画像1"
        name="images.0"
        :error="error"
      />

      <div class="buttons">
        <button id="submit" class="button is-primary" @click="onSubmit()">
          保存する
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import { ReportStore } from '@/store'
import TextInput from '@/components/form/TextInput'
import SelectInput from '@/components/form/SelectInput'
import ImageInput from '@/components/form/ImageInput'
import DateInput from '@/components/form/DateInput'
import TagifyInput from '@/components/form/TagifyInput'

const mapTags = (tags) => {
  return tags.map((tag) => {
    return tag.text
  })
}

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
  title = ''
  content = ''
  status = ''
  rating = ''
  file = null
  opened_at = null
  error = {}
  place_tags = []
  player_tags = []
  other_tags = []

  async onSubmit () {
    if (confirm('追加してもよろしいですか？')) {
      await this.addReport(
        {
          title: this.title,
          content: this.content,
          status: this.status,
          rating: this.rating,
          file: this.file,
          place_tags: mapTags(this.place_tags),
          player_tags: mapTags(this.player_tags),
          other_tags: mapTags(this.other_tags)
        }
      ).then(() => {
        Snackbar.open({
          duration: 5000,
          message: 'レポートを追加しました。',
          type: 'is-success'
        })
        this.$router.push('/')
      }).catch((error) => {
        this.$set(this, 'error', error.response.data.errors)
      })
    }
  }

  async addReport (params) {
    const formData = new FormData()
    if (this.$isset(params.file)) {
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
    formData.append('place_tags', params.place_tags)
    formData.append('player_tags', params.player_tags)
    formData.append('other_tags', params.other_tags)
    await ReportStore.updateReport(formData)
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
