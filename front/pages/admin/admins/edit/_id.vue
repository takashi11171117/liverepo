<template>
  <section class="container">
    <h1 class="title">
      メンバー編集
    </h1>
    <TextInput
      :value="form.name"
      label="名前"
      name="name"
      placeholder="名前"
      :error="form.error"
      @input="onInput('name', $event)"
    />

    <TextInput
      :value="form.email"
      label="メールアドレス"
      name="email"
      type="email"
      placeholder="メールアドレス"
      :error="form.error"
      @input="onInput('email', $event)"
    />

    <TextInput
      :value="form.password"
      label="パスワード"
      name="password"
      type="password"
      placeholder="パスワード"
      :error="form.error"
      @input="onInput('password', $event)"
    />

    <TextInput
      id="password-confirm"
      :value="form.passwordConfirm"
      label="パスワード確認"
      type="password"
      :error="form.error"
      @input="onInput('passwordConfirm', $event)"
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
import { AdminStore, AdminEditStore } from '@/store'
import TextInput from '@/components/form/TextInput.vue'

@Component({
  components: {
    TextInput
  },
  layout: 'admin',
  middleware: ['redirectIfAdminGuest']
})
export default class Admin extends Vue {
  get form () {
    return AdminEditStore.getForm
  }

  async fetch (this: void, ctx: nuxtContext): Promise<void> {
    await AdminStore.loadAdmin(ctx.params.id)
    const admin = AdminStore.getAdmin
    const args = {
      name: admin.name,
      email: admin.email
    }

    AdminEditStore.updateForm(args)
  }

  onInput (name: string, event: any) {
    AdminEditStore.updateInput({ [name]: event })
  }

  async updateAdmin () {
    if (confirm('更新してもよろしいですか？')) {
      const params: any = {}
      params.id = (this as any).$route.params.id
      params.name = this.form.name
      params.email = this.form.email

      if (this.form.password !== '') {
        params.password = this.form.password
        params.password_confirmation = this.form.passwordConfirm
      }

      const response = await AdminStore.updateAdmin(params).catch((err: any) => {
        AdminEditStore.updateFormError(err.response.data.errors)
        return { err }
      })

      if (response && response.err) {
        return
      }

      await AdminStore.loadAdmin((this as any).$route.params.id)
      const admin = AdminStore.getAdmin
      AdminEditStore.updateForm({
        name: admin.name,
        email: admin.email,
        password: '',
        passwordConfirm: ''
      })
      Snackbar.open({
        duration: 5000,
        message: '管理者情報を更新しました。',
        type: 'is-success'
      })
    }
  }
}
</script>
