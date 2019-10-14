<template>
  <div class="section">
    <div class="container is-fluid">
      <div class="columns is-centered">
        <div class="column is-6">
          <h1 class="title is-4">
            ログイン
          </h1>
          <form action="" @submit.prevent="signin">
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

            <div class="control">
              <button id="login-button" class="button is-info is-medium">
                ログイン
              </button>
            </div>
            <hr class="is-divider">
            <p>
              アカウントを持っていない場合は
              <n-link :to="{name: 'auth-register'}">
                新規登録
              </n-link>
              から。
            </p>
          </form>
          <hr class="is-divider">
          <p>お持ちのアカウントで登録/ログイン</p>
          <n-link :to="{ name: 'oauth-twitter-redirect' }" class="button twitter">
            <i class="fab fa-twitter" />ツイッターでログイン/新規登録
          </n-link>
          <hr class="is-divider">
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import TextInput from '@/components/form/TextInput.vue'

@Component({
  components: {
    TextInput
  }
})
export default class Login extends Vue {
  form: { email: string, password: string } = {
    email: '',
    password: ''
  }

  error: Object = {}

  async signin () {
    await this.$auth.loginWith('local', {
      data: this.form
    })
      .then(() => {
        if (this.$route.query.redirect) {
          this.$router.replace(this.$route.query.redirect)
          return
        }

        this.$router.replace({
          name: 'index'
        })
      })
      .catch((error: any) => {
        this.error = error.response.data.errors
      })
  }
}
</script>

<style lang="sass" scoped>
.section
    background-color: white
    border-radius: 10px
.twitter
    background-color: #00A3E2
    color: white
</style>
