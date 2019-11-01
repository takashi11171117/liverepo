<template>
  <div class="columns">
    <aside class="column is-narrow-desktop is-narrow-tablet side-content">
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
          :value="form.user_name01"
          name="user_name01"
          placeholder="姓"
          :error="form.error"
          @input="onInput('user_name01', $event)"
        />

        <TextInput
          :value="form.user_name02"
          name="user_name02"
          placeholder="名"
          :error="form.error"
          @input="onInput('user_name02', $event)"
        />

        <TextInput
          :value="form.description"
          label="紹介文"
          name="description"
          type="textarea"
          placeholder="紹介文"
          :error="form.error"
          @input="onInput('description', $event)"
        />

        <RadioInput
          :value="form.show_mail_flg"
          name="show_mail_flg"
          label="メールの表示"
          :error="form.error"
          :options="{0: '表示しない', 1: '表示する'}"
          @input="onInput('show_mail_flg', $event)"
        />

        <TextInput
          :value="form.url"
          label="URL"
          name="url"
          placeholder="URL"
          :error="form.error"
          @input="onInput('url', $event)"
        />

        <SelectInput
          :value="form.gender"
          name="gender"
          label="性別"
          :error="form.error"
          :options="$data.genderOption"
          @input="onInput('gender', $event)"
        />

        <DateInput
          :value="form.birth"
          label="生年月日"
          name="birth"
          :error="form.error"
          @input="onInput('birth', $event)"
        />

        <p class="icon-title">
          アイコン選択
        </p>
        <div v-if="$isset(user.thumb)" class="img">
          <img :src="user.thumb" alt="">
        </div>

        <ImageInput
          :value="form.file"
          label="アイコン"
          name="image"
          :error="form.error"
          @input="onInput('file', $event)"
        />

        <div class="buttons">
          <button id="submit" class="button is-primary" @click="onSubmit()">
            保存する
          </button>
        </div>
      </section>
    </main>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import moment from 'moment'
import { nuxtContext } from '@/src/@types'
import { UserStore, FrontProfileStore } from '@/store'
import TextInput from '@/components/form/TextInput.vue'
import ImageInput from '@/components/form/ImageInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import DateInput from '@/components/form/DateInput.vue'
import RadioInput from '@/components/form/RadioInput.vue'

@Component({
  components: {
    TextInput,
    ImageInput,
    SelectInput,
    DateInput,
    RadioInput
  },
  middleware: [
    'redirectIfGuest'
  ]
})
export default class SettingProfile extends Vue {
  get form () {
    return FrontProfileStore.getForm
  }

  get user () {
    return UserStore.getUser
  }

  async fetch (this: void, ctx: nuxtContext): Promise<void> {
    await UserStore.loadUser(ctx.app.$auth.user.name)
    const user = UserStore.getUser
    const args = {
      user_name01: user.user_name01,
      user_name02: user.user_name02,
      description: user.description,
      gender: user.gender,
      birth: new Date(user.birth),
      url: user.url,
      show_mail_flg: user.show_mail_flg
    }

    FrontProfileStore.updateForm(args)
  }

  onInput (name: string, event: any) {
    FrontProfileStore.updateInput({ [name]: event })
  }

  async onSubmit () {
    if (confirm('追加してもよろしいですか？')) {
      await this.addProfile(
        {
          user_name01: this.form.user_name01,
          user_name02: this.form.user_name02,
          description: this.form.description,
          gender: this.form.gender,
          birth: moment(this.form.birth).format('YYYY-MM-DD HH:mm:ss'),
          url: this.form.url,
          show_mail_flg: this.form.show_mail_flg,
          file: this.form.file
        }
      ).catch((err: any) => {
        FrontProfileStore.updateFormError(err.response.data.errors)
      })

      if (Object.keys(this.form.error).length !== 0) {
        return
      }

      await UserStore.loadUser((this as any).$auth.user.name)
      const user = UserStore.getUser
      FrontProfileStore.updateForm({
        user_name01: user.user_name01,
        user_name02: user.user_name02,
        description: user.description,
        gender: user.gender,
        url: user.url,
        show_mail_flg: user.show_mail_flg,
        birth: new Date(user.birth),
        file: null,
        error: {}
      })
      Snackbar.open({
        duration: 5000,
        message: 'プロフィールを編集しました。',
        type: 'is-success'
      })
    }
  }

  async addProfile (params: { user_name01: string, user_name02: string, description: string, url: string, gender: string, birth: string, show_mail_flg: string, file: File|null }) {
    const formData = new FormData()
    if (params.file !== null) {
      const blob = await this.$imageCompress(params.file)
      const compressedFile = new File([blob], params.file.name)
      formData.append('image', compressedFile)
    }

    formData.append('user_name01', params.user_name01)
    formData.append('user_name02', params.user_name02)
    formData.append('description', params.description)
    formData.append('birth', params.birth)
    formData.append('gender', params.gender)
    formData.append('show_mail_flg', params.show_mail_flg)
    formData.append('url', params.url)
    formData.append('user_id', (this as any).$auth.user.id)

    await UserStore.updateUserProfile(formData)
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

.side-content
  @media screen and (min-width: 768px)
    width: 320px

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
            object-fit: cover

    .file-button
        display: flex
        margin-bottom: 10px
</style>
