<template>
    <section class="container">
        <h1 class="title">メンバー編集</h1>
        <TextInput
                label="名前"
                name="name"
                :value="name"
                @input="UPDATE_INPUT({'name': $event})"
                placeholder="名前"
                :error="error"
        />

        <TextInput
                label="メールアドレス"
                name="email"
                type="email"
                :value="email"
                @input="UPDATE_INPUT({'email': $event})"
                placeholder="メールアドレス"
                :error="error"
        />

        <TextInput
                label="パスワード"
                name="password"
                type="password"
                :value="password"
                @input="UPDATE_INPUT({'password': $event})"
                placeholder="パスワード"
                :error="error"
        />

        <TextInput
                label="パスワード確認"
                id="password-confirm"
                type="password"
                :value="passwordConfirm"
                @input="UPDATE_INPUT({'passwordConfirm': $event})"
                :error="error"
        />

        <div class="buttons">
            <button id="submit" @click="updateAdmin()" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import TextInput from '../../components/TextInput';
  import {mapGetters, mapActions, mapMutations} from 'vuex';

  export default {
    middleware: 'auth',

    layout: 'admin',

    components: {
      TextInput,
    },

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
      ...mapMutations('admin-edit', ['UPDATE_INPUT']),
    }
  }
</script>