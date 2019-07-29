<template>
    <div class="form">
        <h1>レポート投稿</h1>
        <TextInput
                name="title"
                v-model="title"
                placeholder="タイトルを入力"
                :error="error"
        />

        <TextInput
                name="content"
                v-model="content"
                placeholder="本文を入力"
                :error="error"
                type="textarea"
        />

        <SelectInput
                name="status"
                v-model="status"
                :error="error"
                :options="$data.reportStatus"
        />

        <SelectInput
                name="rating"
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
    </div>
</template>

<script>
  import TextInput from '../../components/TextInput';
  import SelectInput from '../../components/SelectInput';
  import TagifyInput from '../../components/TagifyInput';
  import ImageInput from '../../components/ImageInput';

  export default {
    middleware: [
      'redirectIfGuest'
    ],

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
            this.$router.push('/');
          }).catch((error) => {
            console.log(error);
            this.$set(this, 'error', error.response.data.errors);
          })
        }
      },
      async addReport({title, content, status, rating, file, tags}) {
        let formData = new FormData;
        formData.append('title', title);
        formData.append('content', content);
        formData.append('status', status);
        formData.append('rating', rating);
        formData.append('images[]', file);
        formData.append('tags', tags);
        await this.$axios.$post(
          `setting/report/${this.$auth.user.id}`,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
        );
      }
    }
  }
</script>

<style scoped lang="sass">
    .form
        margin-top: 30px
        margin-bottom: 100px
        margin-left: 20px
        margin-right: 20px
        h1
            font-size: 28px
            font-weight: bold
            margin-bottom: 20px
</style>