import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

const splitArray = (list: Array<string>, divide: number): Array<any> => {
  const splitList = []
  for (let i = 0; i < list.length; i += divide) {
    // 指定した個数ずつに分割する
    splitList.push(list.slice(i, i + divide))
  }

  return splitList
}

@Module({ stateFactory: true, namespaced: true, name: 'repos/report_tag' })
export default class ReportTag extends VuexModule {
  reportTags: Object = {}
  reportTag: Object = {}

  get getReportTags (): Object {
    return this.reportTags
  }

  get getReportTag (): Object {
    return this.reportTag
  }

  @Mutation
  setReportTags (reportTags: Object) {
    this.reportTags = reportTags
  }

  @Mutation
  setReportTag (reportTag: Object) {
    this.reportTag = reportTag
  }

  @Action({ rawError: true })
  async loadReportTag (name: string) {
    const reportTag = await this.$axios.$get(`/comedy/report_tags/${encodeURI(name)}`)

    this.setReportTag(reportTag.data)

    return reportTag.data.id
  }

  @Action({ rawError: true })
  async loadReportTags () {
    const tmpReportTags = await this.$axios.$get('/comedy/report_tags')
    const reportTags = splitArray(tmpReportTags.data, 25)

    this.setReportTags(reportTags)
  }

  @Action({ rawError: true })
  async loadTagify (tag: string) {
    const tags = await this.$axios.$get(`/comedy/report_tags/tagify?tag=${tag}`)

    return tags
  }
}
