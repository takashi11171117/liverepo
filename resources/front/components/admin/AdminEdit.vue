<template>
    <section class="container">
        <h1 class="title">メンバー編集</h1>
        <b-field
                label="名前"
                :type="error.hasOwnProperty('name') ? 'is-danger': ''"
                :message="error.hasOwnProperty('name') ? error.name[0] : ''"
        >
            <b-input :value="name"
                     @input="updateInput({'name': $event})"
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
                     @input="updateInput({'email': $event})"
                     :value="email"
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
                     @input="updateInput({'password': $event})"
                     :value="password">
            </b-input>
        </b-field>

        <b-field label="パスワード確認">
            <b-input type="password"
                     id="password-confirm"
                     @input="updateInput({'passwordConfirm': $event})"
                     :value="passwordConfirm">
            </b-input>
        </b-field>

        <div class="buttons">
            <button id="submit" @click="updateAdmin()" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import {mapGetters, mapActions, mapMutations} from 'vuex'

  export default {
    middleware: 'auth',

    layout: 'admin',

    computed: {
      ...mapGetters(
        {
          admin: 'admin-edit/admin',
          name: 'admin-edit/name',
          email: 'admin-edit/email',
          password: 'admin-edit/password',
          passwordConfirm: 'admin-edit/passwordConfirm',
          error: 'admin-edit/error',
        }
      )
    },

    methods: {
      ...mapActions('admin-edit', ['updateAdmin']),
      ...mapMutations('admin-edit', ['updateInput']),
    }
  }
</script>