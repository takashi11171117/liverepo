import { VuexModule, Module, Mutation } from 'vuex-module-decorators'

type FrontProfileForm = {
  user_name01: string
  user_name02: string
  description: string
  gender: string
  url: string
  show_mail_flg: string
  birth: Date
  file: File|null
  error: {}
}

@Module({ stateFactory: true, namespaced: true, name: 'form/front_profile' })
export default class FrontProfile extends VuexModule {
  form: FrontProfileForm = {
    user_name01: '',
    user_name02: '',
    description: '',
    gender: '',
    url: '',
    show_mail_flg: '',
    birth: new Date(),
    file: null,
    error: {}
  }

  get getForm (): FrontProfileForm {
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
