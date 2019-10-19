import { VuexModule, Module, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/report_comment' })
export default class ReportComment extends VuexModule {
  @Action({ rawError: true })
  async updateReportComment (body: string, id: number) {
    await this.$axios.$post(
      'report_comments',
      {
        body,
        report_id: id
      },
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    )
  }
}
