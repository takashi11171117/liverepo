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
                                <input class="input" type="email" v-model="form.email">
                            </div>
                            <template v-if="error.hasOwnProperty('email') && error.email.length > 0">
                                <p class="info info--error" v-for="value in error.email">
                                    {{ value }}
                                </p>
                            </template>
                        </div>

                        <div class="field">
                            <label class="label">パスワード</label>
                            <div class="control">
                                <input class="input" type="password" v-model="form.password" placeholder="パスワード">
                            </div>
                            <template v-if="error.hasOwnProperty('password') && error.password.length > 0">
                                <p class="info info--error" v-for="value in error.password">
                                    {{ value }}
                                </p>
                            </template>
                        </div>

                        <div class="field">
                            <p class="control">
                                <button class="button is-info is-medium" id="login-button">
                                    ログイン
                                </button>
                            </p>
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
          password: '',
        },
        error: {},
      }
    },

    middleware: [
      'redirectIfAuthenticated'
    ],

    methods: {
      async signin () {
        await this.$auth.loginWith('local', {
          data: this.form
        })
          .then(() => {
            if (this.$route.query.redirect) {
              this.$router.replace(this.$route.query.redirect);
              return;
            }

            this.$router.replace({
              name: 'index'
            })
          })
          .catch(error => {
            this.error = error.response.data.errors;
          });
      }
    }
  }
</script>