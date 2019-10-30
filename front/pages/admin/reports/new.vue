<template>
  <section class="container">
    <h1 class="title">
      レポート追加
    </h1>
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
      type="textarea"
      placeholder="本文を入力"
      :error="error"
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
      name="tags"
      :error="error"
      :report_tags="report_tags"
      :on-update="newTags => report_tags = newTags"
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
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import { ReportStore } from '@/store'
import TextInput from '@/components/form/TextInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import TagifyInput from '@/components/form/TagifyInput.vue'
import ImageInput from '@/components/form/ImageInput.vue'

@Component({
  components: {
    TextInput,
    SelectInput,
    TagifyInput,
    ImageInput
  },
  layout: 'admin',
  middleware: ['redirectIfAdminGuest']
})
export default class ReportNew extends Vue {
    title = ''
    content = ''
    status = ''
    rating = ''
    file = null
    error = {}
    report_tags = []

    async onSubmit () {
      const report_tags = this.report_tags.map((tag: {text: string}) => {
        return tag.text
      })
      if (confirm('追加してもよろしいですか？')) {
        await ReportStore.addReport(
          {
            form: {
              title: this.title,
              content: this.content,
              status: this.status,
              rating: this.rating,
              file: this.file,
              tags: report_tags
            },
            auth: 'admin'
          }
        ).catch((error) => {
          this.$set(this, 'error', error.response.data.errors)
        })

        if (Object.keys(this.error).length !== 0) {
          return
        }

        Snackbar.open({
          duration: 5000,
          message: 'レポートを追加しました。',
          type: 'is-success'
        });
        (this as any).$router.push('/admin/reports')
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
