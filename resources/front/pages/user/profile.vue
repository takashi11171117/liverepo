<template>
    <main class="main">
        <section class="columns is-multiline">
            <div class="column is-narrow-desktop is-narrow-tablet side-content">
                <section class="main-content">
                    <p><a href="#">プロフィールを編集</a></p>
                    <hr class="dropdown-divider">
                </section>
            </div>
            <div class="column">
                <section class="main-content border-radius">
                    <b-field
                            :type="error.hasOwnProperty('user_name01') ? 'is-danger': ''"
                            :message="error.hasOwnProperty('user_name01') ? error.user_name01[0] : ''"
                    >
                        <b-input id="user_name01"
                                 v-model="user_name01"
                                 placeholder="姓">
                        </b-input>
                    </b-field>

                    <b-field
                            :type="error.hasOwnProperty('user_name02') ? 'is-danger': ''"
                            :message="error.hasOwnProperty('user_name02') ? error.user_name02[0] : ''"
                    >
                        <b-input id="user_name02"
                                 v-model="user_name02"
                                 placeholder="姓">
                        </b-input>
                    </b-field>

                    <b-field
                            label="アイコン"
                            :type="error.hasOwnProperty('image') ? 'is-danger': ''"
                            :message="error.hasOwnProperty('image') ? error['image'][0] : ''"
                    >
                        <div class="file-button">
                            <b-upload
                                    v-model="file"
                                    id="image"
                                    v-preview-input="image"
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
                            <img :src="image">
                        </div>
                    </b-field>

                    <div class="buttons">
                        <button id="submit" @click="onSubmit()" class="button is-primary">保存する</button>
                    </div>
                </section>
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

    data() {
      return {
        user_name01: '',
        user_name02: '',
        file: null,
        error: {},
        image: null,
      }
    },

    methods: {
      async onSubmit() {
        if (confirm('追加してもよろしいですか？')) {
          await this.addProfile(
            {
              user_name01: this.user_name01,
              user_name02: this.user_name02,
              file: this.file,
            }
          ).then(() => {
            this.$snackbar.open({
              duration: 5000,
              message: 'プロフィールを編集しました。',
              type: 'is-success',
            });
          }).catch((error) => {
            console.log(error);
            this.$set(this, 'error', error.response.data.errors);
          })
        }
      },

      async addProfile({user_name01, user_name02, file}) {
        let formData = new FormData;
        formData.append('user_name01', user_name01);
        formData.append('user_name02', user_name02);
        formData.append('image', file);
        formData.append('user_id', this.$auth.user.id);
        await this.$axios.$post(
          'user/profile',
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