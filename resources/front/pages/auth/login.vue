<template>
    <div class="section">
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column is-6">
                    <h1 class="title is-4">ログイン</h1>
                    <form action="" @submit.prevent="signin">
                        <TextInput
                                label="メールアドレス"
                                name="email"
                                type="email"
                                v-model="form.email"
                                placeholder="メールアドレス"
                                :error="error"
                        />

                        <TextInput
                                label="パスワード"
                                name="password"
                                type="password"
                                v-model="form.password"
                                placeholder="パスワード"
                                :error="error"
                        />

                        <div class="control">
                            <button class="button is-info is-medium" id="login-button">
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import TextInput from '../../components/TextInput';

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

    components: {
      TextInput,
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