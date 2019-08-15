<template>
    <div class="columns">
        <aside class="column is-narrow-desktop is-narrow-tablet">
            <section class="main-content">
                <p>
                    <n-link :to="{ name: 'setting-profile' }">
                        プロフィールを編集
                    </n-link>
                </p>
                <hr class="dropdown-divider">
            </section>
        </aside>
        <main class="column">
            <section class="main-content border-radius">
                <h1>プロフィール編集</h1>
                <TextInput
                        name="user_name01"
                        v-model="user_name01"
                        placeholder="姓"
                        :error="error"
                />

                <TextInput
                        name="user_name02"
                        v-model="user_name02"
                        placeholder="名"
                        :error="error"
                />

                <TextInput
                        label="紹介文"
                        name="description"
                        type="textarea"
                        v-model="description"
                        placeholder="紹介文"
                        :error="error"
                />

                <RadioInput
                        name="show_mail_flg"
                        label="メールの表示"
                        v-model="show_mail_flg"
                        :error="error"
                        :options="{0: '表示しない', 1: '表示する'}"
                />

                <TextInput
                        label="URL"
                        name="url"
                        v-model="url"
                        placeholder="URL"
                        :error="error"
                />

                <SelectInput
                        name="gender"
                        label="性別"
                        v-model="gender"
                        :error="error"
                        :options="$data.genderOption"
                />

                <DateInput
                        label="生年月日"
                        name="birth"
                        v-model="birth"
                        :error="error"
                />

                <ImageInput
                        label="アイコン"
                        v-model="file"
                        name="image"
                        :error="error"
                />

                <div class="buttons">
                    <button id="submit" @click="onSubmit()" class="button is-primary">保存する</button>
                </div>
            </section>
        </main>
    </div>
</template>

<script>
  import TextInput from '../../components/TextInput';
  import ImageInput from '../../components/ImageInput';
  import SelectInput from '../../components/SelectInput';
  import DateInput from '../../components/DateInput';
  import RadioInput from '../../components/RadioInput';

  export default {
    middleware: [
      'redirectIfGuest'
    ],

    components: {
      TextInput,
      ImageInput,
      SelectInput,
      DateInput,
      RadioInput
    },

    data() {
      return {
        user_name01: '',
        user_name02: '',
        description: '',
        gender: '',
        url: '',
        show_mail_flg: '',
        birth: null,
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
              description: this.description,
              gender: this.gender,
              birth: this.birth,
              url: this.url,
              show_mail_flg: this.show_mail_flg,
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

      async addProfile({user_name01, user_name02, description, url, gender, birth, show_mail_flg, file}) {
        let formData = new FormData;

        if (this.$isset(birth)) {
          let date = Date.format(birth, "Y/m/d H:i:s");
          formData.append('birth', date);
        }

        if (this.$isset(file)) {
          const blob = await this.$imageCompress(file);
          const compressedFile = new File([blob], blob.name);
          formData.append('image', compressedFile);
        }

        formData.append('user_name01', user_name01);
        formData.append('user_name02', user_name02);
        formData.append('description', description);
        formData.append('gender', gender);
        formData.append('show_mail_flg', show_mail_flg);
        formData.append('url', url);
        formData.append('user_id', this.$auth.user.id);
        await this.$axios.$post(
          'setting/profile',
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
    .main-content
        background-color: #fff
        border-radius: 8px
        padding: 15px 20px
        h1
            padding: 10px 0 10px 0
            font-size: 20px
            font-weight: bold
            line-height: 1.2

    .has-addons
        display: block

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