import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/report' })
export default class Report extends VuexModule {
  reports: Object = {}

  get getReports (): Object {
    return this.reports
  }

  @Mutation
  setReports (reports: Object) {
    this.reports = reports
  }

  @Action({ rawError: true })
  async loadReports (params: {page: number, per_page: number} = { page: 1, per_page: 20 }) {
    const reports = await this.$axios.$get('/comedy/reports', {
      params: {
        page: params.page,
        per_page: params.per_page
      }
    })

    this.setReports(reports)
  }

  @Action({ rawError: true })
  async loadReportsByUser (name: string, params: {page: number, per_page: number} = { page: 1, per_page: 20 }) {
    const reports = await this.$axios.$get(`/users/${name}/reports`, {
      params: {
        page: params.page,
        per_page: params.per_page
      }
    })

    this.setReports(reports)
  }

  @Action({ rawError: true })
  async updateReport (form: Object) {
    await this.$axios.$post(
      'comedy/reports',
      form,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    )
  }
}
