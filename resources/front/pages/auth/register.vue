<template>
    <div class="section">
        <div class="container is-fluid">
            <div class="columns is-centered">
                <div class="column is-6">
                    <h1 class="title is-4">新規登録(無料)</h1>
                    <form action="" @submit.prevent="register">
                        <TextInput
                                label="ユーザー名"
                                name="name"
                                v-model="form.name"
                                placeholder="ユーザー名"
                                :error="error"
                        />

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

                        <TextInput
                                label="パスワード確認"
                                name="password-confirm"
                                v-model="form.password_confirmation"
                                type="password"
                                :error="error"
                        />

                        <SelectInput
                                name="gender"
                                label="性別"
                                v-model="form.gender"
                                :error="error"
                                :options="$data.genderOption"
                        />

                        <SelectInput
                                name="pref"
                                label="都道府県"
                                v-model="form.pref"
                                :error="error"
                                :options="$data.prefsOption"
                        />

                        <DateInput
                                label="生年月日"
                                name="birth"
                                v-model="form.birth"
                                :error="error"
                        />

                        <p class="kiyaku">
                            利用規約に同意のうえ、「利用規約に同意して登録」ボタンを押してください。
                        </p>

                        <div class="field">
                            <p class="control">
                                <button class="button is-info is-medium" id="login-button">
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

<script>
  import TextInput from '../../components/TextInput';
  import SelectInput from '../../components/SelectInput';
  import DateInput from '../../components/DateInput';

  export default {
    data () {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          gender: '',
          pref: '',
          birth: null
        },
        error: {}
      }
    },

    components: {
      TextInput,
      SelectInput,
      DateInput
    },

    middleware: [
      'redirectIfAuthenticated'
    ],

    methods: {
      async register () {
        let newForm = Object.assign({}, this.form);
        if(this.$isset(this.form.birth)) {
          newForm.birth = Date.format(this.form.birth, "Y/m/d H:i:s");
        }
        await this.$axios.$post('/auth/register', newForm)
          .then(() => {
            this.$router.replace({
              name: 'auth-login'
            })
          })
          .catch(error => {
            this.error = error.response.data.errors;
          });
      }
    }
  }
</script>

<style lang="sass" scoped>
    .kiyaku
        margin-bottom: 10px
        margin-top: 20px
</style>