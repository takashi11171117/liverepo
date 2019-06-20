<template>
    <main class="main">
        <section class="columns is-mobile is-multiline">
            <div class="column">
                <b-field
                        :type="error.hasOwnProperty('title') ? 'is-danger': ''"
                        :message="error.hasOwnProperty('title') ? error.title[0] : ''"
                >
                    <b-input id="title"
                             v-model="title"
                             placeholder="タイトルを入力">
                    </b-input>
                </b-field>

                <b-field
                        :type="error.hasOwnProperty('content') ? 'is-danger': ''"
                        :message="error.hasOwnProperty('content') ? error.content[0] : ''"
                >
                    <b-input id="content"
                             type="textarea"
                             v-model="content"
                             placeholder="本文を入力">
                    </b-input>
                </b-field>

                <b-field
                        :type="error.hasOwnProperty('status') ? 'is-danger': ''"
                        :message="error.hasOwnProperty('status') ? error.status[0] : ''"
                >
                    <b-select v-model="status" id="status">
                        <option
                                v-for="(status, key) in $data.reportStatus"
                                v-bind:value="key"
                                :key="key">
                            {{ status }}
                        </option>
                    </b-select>
                </b-field>

                <b-field
                        :type="error.hasOwnProperty('rating') ? 'is-danger': ''"
                        :message="error.hasOwnProperty('rating') ? error.rating[0] : ''"
                >
                    <b-select v-model="rating" id="rating">
                        <option
                                v-for="(rating, key) in $data.reportRating"
                                v-bind:value="key"
                                :key="key">
                            {{ rating }}
                        </option>
                    </b-select>
                </b-field>

                <b-field
                        id="tagify"
                        :type="error.hasOwnProperty('tags') ? 'is-danger': ''"
                        :message="error.hasOwnProperty('tags') ? error['tags'][0] : ''"
                >
                    <Tagify
                            :prop_tags="report_tags"
                            :onUpdate="newTags => report_tags = newTags"
                    />
                </b-field>

                <b-field
                        label="画像1"
                        :type="error.hasOwnProperty('images.0') ? 'is-danger': ''"
                        :message="error.hasOwnProperty('images.0') ? error['images.0'][0] : ''"
                >
                    <div class="file-button">
                        <b-upload
                                v-model="file"
                                id="image1"
                                v-preview-input="image1"
                                accept="image/*"
                        >
                            <a class="button is-primary">
                                <b-icon icon="upload"></b-icon>
                                <span>Click to upload</span>
                            </a>
                        </b-upload>
                        <span class="file-name" v-if="file">
                            {{ file.name }}
                        </span>
                    </div>

                    <div v-if="file">
                        <img :src="image1">
                    </div>
                </b-field>

                <div class="buttons">
                    <button id="submit" @click="onSubmit()" class="button is-primary">保存する</button>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
  import Tagify from '../../components/Tagify';
  import {mapActions} from 'vuex'

  export default {
    middleware: [
      'redirectIfGuest'
    ],

    components: {
      Tagify,
    },

    data() {
      return {
        title: '',
        content: '',
        status: '0',
        rating: '1',
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
            this.$router.push('/admin/report');
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
          `user/report/add/${this.$auth.user.id}`,
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