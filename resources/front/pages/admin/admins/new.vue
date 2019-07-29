<template>
    <section class="container">
        <h1 class="title">メンバー追加</h1>
        <TextInput
                label="名前"
                name="name"
                v-model="name"
                placeholder="名前"
                :error="error"
        />

        <TextInput
                label="メールアドレス"
                name="email"
                v-model="email"
                placeholder="メールアドレス"
                :error="error"
        />

        <TextInput
                label="パスワード"
                name="password"
                v-model="password"
                type="password"
                :error="error"
        />

        <TextInput
                label="パスワード確認"
                name="password-confirm"
                v-model="passwordConfirm"
                type="password"
                :error="error"
        />

        <div class="buttons">
            <button id="submit" @click="onSubmit()" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import {mapActions} from 'vuex'
  import TextInput from '../../../components/TextInput';

  export default {
    middleware: [
      'redirectIfAdminGuest'
    ],

    layout: 'admin',

    components: {
      TextInput
    },

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