import { VuexModule, Module, Mutation } from 'vuex-module-decorators'

type ReportPostForm = {
  title: string
  content: string
  status: string
  rating: string
  report_images: Array<File>,
  place_tags: Array<string>,
  player_tags: Array<string>,
  other_tags: Array<string>,
  file: File|null,
  opened_at: Date|null,
  error: Object
}

@Module({ stateFactory: true, namespaced: true, name: 'form/front_report_post' })
export default class FrontReportPost extends VuexModule {
  form: ReportPostForm = {
    title: '',
    content: '',
    status: '',
    rating: '',
    report_images: [],
    place_tags: [],
    player_tags: [],
    other_tags: [],
    file: null,
    opened_at: null,
    error: {}
  }

  get getForm (): ReportPostForm {
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
    ['place', 'player', 'other'].forEach((taxonomy) => {
      if (payload[`${taxonomy}_tags`]) {
        payload[`${taxonomy}_tags`] = payload[`${taxonomy}_tags`].map((tag: { text: string }) => {
          return tag.text
        })
      }
    })
    this.form = Object.assign(this.form, payload)
  }
}
