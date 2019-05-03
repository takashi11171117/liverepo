<template>
    <div>
        <h1 class="title">メンバー編集</h1>
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
            <b-input type="password"
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
    </div>
</template>

<script>
  export default {
    data() {
      return {
        admin: {},
        name: '',
        email: '',
        password: '',
        passwordConfirm: '',
        error: {},
      }
    },

    async asyncData({params, $axios, redirect}) {
      let data = {};
      try {
        data = await $axios.$get(`/admin/admin/${params.id}`);

        return {
          admin: data,
          name: data.name,
          email: data.email,
        }
      } catch (error) {
        redirect({
          path: '/admin/login'
        });
      }
    },

    methods: {
      async onSubmit() {
        if (confirm('更新してもよろしいですか？')) {
          let data = {};

          try {
            data = await this.$axios.$post(
              `/admin/admin/${this.admin.id}/update`,
              {
                _method: 'PUT',
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.passwordConfirm,
              }
            );

            this.$set(this, 'admin', data);
            this.$set(this, 'error', {});
            this.$set(this, 'password', '');
            this.$set(this, 'passwordConfirm', '');
            this.$snackbar.open({
              duration: 5000,
              message: '会員情報を更新しました。',
              type: 'is-success',
            });
          } catch (error) {
            this.$set(this, 'error', error.response.data);
          }
        }
      },
    }
  }
</script>