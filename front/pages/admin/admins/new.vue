<template>
  <section class="container">
    <h1 class="title">
      メンバー追加
    </h1>
    <TextInput
      v-model="name"
      label="名前"
      name="name"
      placeholder="名前"
      :error="error"
    />

    <TextInput
      v-model="email"
      label="メールアドレス"
      name="email"
      placeholder="メールアドレス"
      :error="error"
    />

    <TextInput
      v-model="password"
      label="パスワード"
      name="password"
      type="password"
      :error="error"
    />

    <TextInput
      v-model="passwordConfirm"
      label="パスワード確認"
      name="password-confirm"
      type="password"
      :error="error"
    />

    <div class="buttons">
      <button id="submit" class="button is-primary" @click="onSubmit()">
        保存する
      </button>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import { AdminStore } from '@/store'
import TextInput from '@/components/form/TextInput.vue'

@Component({
  components: {
    TextInput
  },
  layout: 'admin',
  middleware: ['redirectIfAdminGuest']
})
export default class AdminNew extends Vue {
  name = ''
  email = ''
  password = ''
  passwordConfirm = ''
  error = {}

  async onSubmit () {
    if (confirm('追加してもよろしいですか？')) {
      await AdminStore.addAdmin(
        {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.passwordConfirm
        }
      ).catch((err: any) => {
        this.$set(this, 'error', err.response.data.errors)
      })

      if (Object.keys(this.error).length !== 0) {
        return
      }

      Snackbar.open({
        duration: 5000,
        message: '会員情報を追加しました。',
        type: 'is-success'
      });
      (this as any).$router.push('/admin')
    }
  }
}
</script>
