import { VuexModule, Module, Mutation } from 'vuex-module-decorators'

type AdminEditForm = {
  name: string
  email: string
  password: string
  passwordConfirm: string
  error: Object
}

@Module({ stateFactory: true, namespaced: true, name: 'form/admin_edit' })
export default class Report_edit extends VuexModule {
  form: AdminEditForm = {
    name: '',
    email: '',
    password: '',
    passwordConfirm: '',
    error: {}
  }

  get getForm (): AdminEditForm {
    return this.form
  }

  @Mutation
  updateForm (form: Object) {
    this.form = Object.assign(this.form, form)
    this.form.error = {}
  }

  @Mutation
  updateFormError (payload: Object) {
    this.form.error = payload
  }

  @Mutation
  updateInput (payload: { [key: string]: any }) {
    this.form = Object.assign(this.form, payload)
  }
}
