<template>
    <section class="container">
        <h1 class="title">メンバー追加</h1>
        <b-field
                label="名前"
                :type="error.hasOwnProperty('name') ? 'is-danger': ''"
                :message="error.hasOwnProperty('name') ? error.name[0] : ''"
        >
            <b-input v-model="name"
                     id="name">
            </b-input>
        </b-field>

        <b-field
                label="メールアドレス"
                :type="error.hasOwnProperty('email') ? 'is-danger': ''"
                :message="error.hasOwnProperty('email') ? error.email[0] : ''"
        >
            <b-input type="email"
                     id="email"
                     v-model="email"
                     maxlength="50">
            </b-input>
        </b-field>

        <b-field
                label="パスワード"
                :type="error.hasOwnProperty('password') ? 'is-danger': ''"
                :message="error.hasOwnProperty('password') ? error.password[0] : ''"
        >
            <b-input
                    type="password"
                    id="password"
                    v-model="password">
            </b-input>
        </b-field>

        <b-field label="パスワード確認">
            <b-input type="password"
                     id="password-confirm"
                     v-model="passwordConfirm">
            </b-input>
        </b-field>

        <div class="buttons">
            <button id="submit" @click="onSubmit()" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    middleware: 'auth',

    layout: 'admin',

    data() {
      return {
        name: '',
        email: '',
        password: '',
        passwordConfirm: '',
        error: {},
      }
    },

    methods: {
      async onSubmit() {
        if (confirm('追加してもよろしいですか？')) {
          await this.addAdmin(
            {
              name: this.name,
              email: this.email,
              password: this.password,
              password_confirmation: this.passwordConfirm,
            }
          ).then(() => {
            this.$snackbar.open({
              duration: 5000,
              message: '会員情報を追加しました。',
              type: 'is-success',
            });
            this.$router.push('/admin');
          }).catch((error) => {
            console.log(error);
            this.$set(this, 'error', error.response.data.errors);
          })
        }
      },
      ...mapActions('admin-index', ['addAdmin'])
    }
  }
</script>