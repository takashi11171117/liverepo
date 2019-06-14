<template>
    <div class="section">
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column is-6">
                    <h1 class="title is-4">ログイン</h1>
                    <form action="" @submit.prevent="signin">
                        <div class="field">
                            <label class="label">メールアドレス</label>
                            <div class="control">
                                <input class="input" type="email" placeholder="e.g. alex@codecourse.com" v-model="form.email">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">パスワード</label>
                            <div class="control">
                                <input class="input" type="password" v-model="form.password">
                            </div>
                        </div>

                        <div class="field">
                            <p class="control">
                                <button class="button is-info is-medium">
                                    ログイン
                                </button>
                            </p>
                        </div>
                        <hr class="is-divider">
                        <p>
                            アカウントを持っていない場合は
                            <nuxt-link :to="{name: 'auth-register'}">
                                新規登録
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
          email: '',
          password: ''
        }
      }
    },

    middleware: [
      'redirectIfAuthenticated'
    ],

    methods: {
      async signin () {
        await this.$auth.loginWith('local', {
          data: this.form
        });

        if (this.$route.query.redirect) {
          this.$router.replace(this.$route.query.redirect);
          return
        }

        this.$router.replace({
          name: 'index'
        })
      }
    }
  }
</script>