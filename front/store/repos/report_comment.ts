import { VuexModule, Module, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/report_comment' })
export default class ReportComment extends VuexModule {
  @Action({ rawError: true })
  async updateReportComment (params: {body: string, report_id: number}) {
    console.log(params)
    await this.$axios.$post(
      'report_comments',
      {
        body: params.body,
        report_id: params.report_id
      }
    )
  }
}
