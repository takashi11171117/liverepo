<template>
  <div class="section">
    <div class="container is-fluid">
      <div class="columns is-centered">
        <div class="column is-6">
          <h1 class="title is-4">
            新規登録(無料)
          </h1>
          <form action="" @submit.prevent="register">
            <TextInput
              v-model="form.name"
              label="ユーザー名"
              name="name"
              placeholder="ユーザー名"
              :error="error"
            />

            <TextInput
              v-model="form.email"
              label="メールアドレス"
              name="email"
              type="email"
              placeholder="メールアドレス"
              :error="error"
            />

            <TextInput
              v-model="form.password"
              label="パスワード"
              name="password"
              type="password"
              placeholder="パスワード"
              :error="error"
            />

            <TextInput
              v-model="form.password_confirmation"
              label="パスワード確認"
              name="password-confirm"
              type="password"
              :error="error"
            />

            <SelectInput
              v-model="form.gender"
              name="gender"
              label="性別"
              :error="error"
              :options="$data.genderOption"
            />

            <SelectInput
              v-model="form.pref"
              name="pref"
              label="都道府県"
              :error="error"
              :options="$data.prefsOption"
            />

            <DateInput
              v-model="form.birth"
              label="生年月日"
              name="birth"
              :error="error"
            />

            <p class="kiyaku">
              利用規約に同意のうえ、「利用規約に同意して登録」ボタンを押してください。
            </p>

            <div class="field">
              <p class="control">
                <button id="login-button" class="button is-info is-medium">
                  利用規約に同意して登録
                </button>
              </p>
            </div>

            <p>
              アカウントを持っている場合は
              <n-link :to="{name: 'auth-login'}">
                ログイン
              </n-link>
              から。
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import TextInput from '@/components/form/TextInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import DateInput from '@/components/form/DateInput.vue'

type Form = {
  name: string
  email: string
  password: string
  password_confirmation: string
  gender: string
  pref: string
  birth: Date
}

@Component({
  components: {
    TextInput,
    SelectInput,
    DateInput
  }
})
export default class Register extends Vue {
  form: Form = {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    gender: '',
    pref: '',
    birth: new Date()
  }

  error: Object = {}

  async register () {
    const newForm = Object.assign({}, this.form)
    if ((this as any).$isset(this.form.birth)) {
      newForm.birth = this.form.birth
    }
    await (this as any).$axios.$post('/auth/register', newForm)
      .then(() => {
        (this as any).$router.replace({
          name: 'auth-login'
        })
      })
      .catch((error: any) => {
        this.error = error.response.data.errors
      })
  }
}
</script>

<style lang="sass" scoped>
.kiyaku
    margin-bottom: 10px
    margin-top: 20px
.section
    background-color: #fff
    border-radius: 10px
</style>
