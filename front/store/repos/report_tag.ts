import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/report_tag' })
export default class ReportTag extends VuexModule {
  reportTags: Object = {}

  get getReportTags (): Object {
    return this.reportTags
  }

  @Mutation
  setReportTags (reportTags: Object) {
    this.reportTags = reportTags
  }

  @Action({ rawError: true })
  loadTagify (tag: string) {
    return this.$axios.$get(`/comedy/report_tags/tagify?tag=${tag}`)
  }
}
