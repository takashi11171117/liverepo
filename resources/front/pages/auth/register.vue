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
                            <template v-if="error.hasOwnProperty('name') && error.name.length > 0">
                                <p class="info info--error" v-for="value in error.name">
                                    {{ value }}
                                </p>
                            </template>
                        </div>

                        <div class="field">
                            <label class="label">メールアドレス</label>
                            <div class="control">
                                <input class="input" type="email" placeholder="メールアドレス" v-model="form.email">
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
                                <input class="input" type="password" v-model="form.password">
                            </div>
                            <template v-if="error.hasOwnProperty('password') && error.password.length > 0">
                                <p class="info info--error" v-for="value in error.password">
                                    {{ value }}
                                </p>
                            </template>
                        </div>

                        <div class="field">
                            <label class="label">性別</label>
                            <div class="control">
                                <b-select
                                        v-model="form.gender"
                                >
                                    <option
                                            v-for="(rating, key) in $data.genderOption"
                                            v-bind:value="key"
                                            :key="key">
                                        {{ rating }}
                                    </option>
                                </b-select>
                            </div>
                            <template v-if="error.hasOwnProperty('gender') && error.gender.length > 0">
                                <p class="info info--error" v-for="value in error.gender">
                                    {{ value }}
                                </p>
                            </template>
                        </div>

                        <div class="field">
                            <label class="label">生年月日</label>
                            <div class="control">
                                <template>
                                    <b-field>
                                        <b-datepicker
                                                placeholder="クリックして選択"
                                                icon="calendar-today"
                                                v-model="form.birth"
                                                :month-names="$data.monthNamesOption"
                                                :day-names="$data.dayNamesOption">
                                        </b-datepicker>
                                    </b-field>
                                </template>
                            </div>
                            <template v-if="error.hasOwnProperty('birth') && error.birth.length > 0">
                                <p class="info info--error" v-for="value in error.birth">
                                    {{ value }}
                                </p>
                            </template>
                        </div>

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
  export default {
    data () {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          gender: '',
          birth: new Date()
        },
        error: {}
      }
    },

    middleware: [
      'redirectIfAuthenticated'
    ],

    methods: {
      async register () {
        await this.$axios.$post('/auth/register', this.form)
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