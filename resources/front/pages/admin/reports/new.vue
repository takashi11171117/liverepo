<template>
    <section class="container">
        <h1 class="title">レポート追加</h1>
        <TextInput
                label="タイトル"
                name="title"
                v-model="title"
                placeholder="タイトルを入力"
                :error="error"
        />

        <TextInput
                label="本文"
                name="content"
                type="textarea"
                v-model="content"
                placeholder="本文を入力"
                :error="error"
        />

        <SelectInput
                label="ステータス"
                name="status"
                v-model="status"
                :error="error"
                :options="$data.reportStatus"
        />

        <SelectInput
                label="評価"
                name="status"
                v-model="rating"
                :error="error"
                :options="$data.reportRating"
        />

        <TagifyInput
                name="tags"
                :error="error"
                :report_tags="report_tags"
                :onUpdate="newTags => report_tags = newTags"
        />

        <ImageInput
                label="画像1"
                v-model="file"
                name="images.0"
                :error="error"
        />

        <div class="buttons">
            <button id="submit" @click="onSubmit()" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import TextInput from '../../../components/TextInput';
  import SelectInput from '../../../components/SelectInput';
  import TagifyInput from '../../../components/TagifyInput';
  import ImageInput from '../../../components/ImageInput';
  import {mapActions} from 'vuex'

  export default {
    middleware: [
      'redirectIfAdminGuest'
    ],

    layout: 'admin',

    components: {
      TextInput,
      SelectInput,
      TagifyInput,
      ImageInput
    },

    data() {
      return {
        title: '',
        content: '',
        status: '',
        rating: '',
        file: null,
        error: {},
        image1: null,
        report_tags: []
      }
    },

    methods: {
      async onSubmit() {
        let report_tags = this.report_tags.map((tag) => {
          return tag.text;
        });
        if (confirm('追加してもよろしいですか？')) {
          await this.addReport(
            {
              title: this.title,
              content: this.content,
              status: this.status,
              rating: this.rating,
              file: this.file,
              tags: report_tags,
            }
          ).then(() => {
            this.$snackbar.open({
              duration: 5000,
              message: 'レポートを追加しました。',
              type: 'is-success',
            });
            this.$router.push('/admin/reports');
          }).catch((error) => {
            console.log(error);
            this.$set(this, 'error', error.response.data.errors);
          })
        }
      },
      ...mapActions('admin-report-index', ['addReport'])
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