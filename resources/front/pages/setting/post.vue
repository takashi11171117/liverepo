<template>
    <div class="section">
        <div class="form">
            <h1>レポート投稿</h1>
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
                    v-model="content"
                    placeholder="本文を入力"
                    :error="error"
                    type="textarea"
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
                    name="rating"
                    v-model="rating"
                    :error="error"
                    :options="$data.reportRating"
            />

            <TagifyInput
                    label="開催場所"
                    name="place_tags"
                    :error="error"
                    :report_tags="place_tags"
                    :onUpdate="newTags => place_tags = newTags"
            />

            <TagifyInput
                    label="出演者"
                    name="player_tags"
                    :error="error"
                    :report_tags="player_tags"
                    :onUpdate="newTags => player_tags = newTags"
            />

            <TagifyInput
                    label="タグ"
                    name="other_tags"
                    :error="error"
                    :report_tags="other_tags"
                    :onUpdate="newTags => other_tags = newTags"
            />

            <DateInput
                    label="開催日時"
                    name="opened_at"
                    v-model="opened_at"
                    :error="error"
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
    </div>
</template>

<script>
  import TextInput from '../../components/TextInput';
  import SelectInput from '../../components/SelectInput';
  import TagifyInput from '../../components/TagifyInput';
  import ImageInput from '../../components/ImageInput';
  import DateInput from '../../components/DateInput';

  const mapTags = (tags) => {
    return tags.map((tag) => {
      return tag.text;
    });
  };

  export default {
    middleware: [
      'redirectIfGuest'
    ],

    components: {
      TextInput,
      SelectInput,
      TagifyInput,
      ImageInput,
      DateInput
    },

    data() {
      return {
        title: '',
        content: '',
        status: '',
        rating: '',
        file: null,
        opened_at: null,
        error: {},
        place_tags: [],
        player_tags: [],
        other_tags: [],
      }
    },

    methods: {
      async onSubmit() {
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
              other_tags: mapTags(this.other_tags),
            }
          ).then(() => {
            this.$snackbar.open({
              duration: 5000,
              message: 'レポートを追加しました。',
              type: 'is-success',
            });
            this.$router.push('/');
          }).catch((error) => {
            console.log(error.response.data);
            this.$set(this, 'error', error.response.data.errors);
          })
        }
      },
      async addReport(params) {
        let formData = new FormData;
        const blob = await this.$imageCompress(params.file);
        const compressedFile = new File([blob], blob.name);
        formData.append('title', params.title);
        formData.append('content', params.content);
        formData.append('status', params.status);
        formData.append('rating', params.rating);
        formData.append('images[]', compressedFile);
        formData.append('place_tags', params.place_tags);
        formData.append('player_tags', params.player_tags);
        formData.append('other_tags', params.other_tags);
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