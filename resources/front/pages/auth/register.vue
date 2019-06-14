<template>
    <div class="section">
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column is-6">
                    <h1 class="title is-4">新規登録(無料)</h1>
                    <form action="" @submit.prevent="register">
                        <div class="field">
                            <label class="label">ユーザー名</label>
                            <div class="control">
                                <input class="input" type=text placeholder="ユーザー名" v-model="form.name">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">メールアドレス</label>
                            <div class="control">
                                <input class="input" type="email" placeholder="メールアドレス" v-model="form.email">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">パスワード</label>
                            <div class="control">
                                <input class="input" type="password" v-model="form.password">
                            </div>
                        </div>

                        <p class="kiyaku">
                            利用規約に同意のうえ、「利用規約に同意して登録」ボタンを押してください。
                        </p>

                        <div class="field">
                            <p class="control">
                                <button class="button is-info is-medium">
                                    利用規約に同意して登録
                                </button>
                            </p>
                        </div>

                        <p>
                            アカウントを持っている場合は
                            <nuxt-link :to="{name: 'auth-login'}">
                                ログイン
                            </nuxt-link>
                            から。
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        form: {
          name: '',
          email: '',
          password: ''
        }
      }
    },

    middleware: [
      'redirectIfAuthenticated'
    ],

    methods: {
      async register () {
        await this.$axios.$post('/auth/register', this.form);

        this.$router.replace({
          name: 'auth-login'
        })
      }
    }
  }
</script>

<style lang="sass" scoped>
    .kiyaku
        margin-bottom: 10px
        margin-top: 20px
</style>