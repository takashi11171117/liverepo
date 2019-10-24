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
      @input="ReportEditStore.updateInput({'title': $event})"
    />

    <TextInput
      label="本文"
      name="content"
      :value="form.content"
      placeholder="本文"
      :error="form.error"
      type="textarea"
      @input="ReportEditStore.updateInput({'content': $event})"
    />

    <SelectInput
      label="ステータス"
      name="status"
      :value="form.status"
      :error="form.error"
      :options="$data.reportStatus"
      @input="ReportEditStore.updateInput({'content': $event})"
    />

    <SelectInput
      label="評価"
      name="rating"
      :value="form.rating"
      :error="form.error"
      :options="$data.reportRating"
      @input="ReportEditStore.updateInput({'content': $event})"
    />

    <TagifyInput
      name="tags"
      label="タグ"
      :error="form.error"
      :report_tags="report_tags"
      :on-update="newTags => report_tags = newTags"
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
      v-model="form.file"
      label="画像1"
      name="images.0"
      :error="form.error"
      @input="ReportEditStore.updateInput({'file': $event})"
    />

    <div class="buttons">
      <button id="submit" class="button is-primary" @click="updateEachData(reportId)">
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
    report_tags: Array<any> = []
    file: File|null = null

    openGallery (index: number) {
      const ref:any = this.$refs.lightbox
      ref.showImage(index)
    }

    get form () {
      return ReportEditStore.getForm
    }

    async fetch (ctx: nuxtContext): Promise<void> {
      await ReportStore.loadReport(ctx.params.id)
      const report = ReportStore.getReport

      type formArgs = {
        title: string
        content: string
        status: string
        rating: string
        report_images: { path: string }[],
        report_tags: { text: string }[]
      }

      const args: formArgs = {
        title: report.title,
        content: report.content,
        status: `${report.status}`,
        rating: `${report.rating}`,
        report_images: report.report_images,
        report_tags: []
      }

      if (this.report_tags !== undefined) {
        args.report_tags = this.report_tags.map((tag) => {
          return { text: tag }
        })
      }

      ReportEditStore.updateForm(args)
    }

    async updateEachData (id: number) {
      if (confirm('更新してもよろしいですか？')) {
        const formData = new FormData()
        const report_tags = this.report_tags.map((tag: {text: string}) => {
          return tag.text
        })
        formData.append('title', this.form.title)
        formData.append('content', this.form.content)
        formData.append('status', this.form.status)
        formData.append('rating', this.form.rating)
        if (this.form.file !== undefined && this.form.file !== null) {
          formData.append('images[]', this.form.file)
        }
        formData.append('tags', JSON.stringify(report_tags))
        formData.append('_method', 'PUT')
        await ReportStore.updateReport(id, formData)
          .catch((err: any) => {
            ReportEditStore.updateFormError(err.response.data.errors)
            return false
          })

        const report = ReportStore.getReport
        ReportEditStore.updateForm({
          title: report.title,
          content: report.content,
          status: report.status,
          rating: report.rating,
          file: report.file
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
