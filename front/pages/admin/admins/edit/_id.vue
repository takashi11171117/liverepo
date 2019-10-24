<template>
  <section class="container">
    <h1 class="title">
      メンバー編集
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
      type="email"
      placeholder="メールアドレス"
      :error="error"
    />

    <TextInput
      v-model="password"
      label="パスワード"
      name="password"
      type="password"
      placeholder="パスワード"
      :error="error"
    />

    <TextInput
      id="password-confirm"
      v-model="passwordConfirm"
      label="パスワード確認"
      type="password"
      :error="error"
    />

    <div class="buttons">
      <button id="submit" class="button is-primary" @click="updateAdmin()">
        保存する
      </button>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { SnackbarProgrammatic as Snackbar } from 'buefy'
import { nuxtContext } from '@/src/@types'
import { AdminStore } from '@/store'
import TextInput from '@/components/form/TextInput.vue'

@Component({
  components: {
    TextInput
  },
  layout: 'admin',
  middleware: ['redirectIfAdminGuest']
})
export default class Admin extends Vue {
  name = ''
  email = ''
  password = ''
  passwordConfirm = ''
  error = {}

  get admin () {
    return AdminStore.getAdmin
  }

  async fetch (this: void, ctx: nuxtContext): Promise<void> {
    await AdminStore.loadAdmin(ctx.params.id)
  }

  async updateAdmin () {
    if (confirm('更新してもよろしいですか？')) {
      await AdminStore.updateAdmin({
        id: this.admin.id,
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.passwordConfirm
      }).catch((err: any) => {
        this.$set(this, 'error', err.response.data.errors)
        return false
      })

      this.name = this.admin.name
      this.email = this.admin.email

      Snackbar.open({
        duration: 5000,
        message: '管理者情報を更新しました。',
        type: 'is-success'
      })
    }
  }
}
</script>
