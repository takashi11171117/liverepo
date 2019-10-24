import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'
import ReportModel from '@/src/models/Report'

@Module({ stateFactory: true, namespaced: true, name: 'repos/report' })
export default class Report extends VuexModule {
  report: ReportModel = {
    id: 0,
    title: '',
    content: '',
    rating: 0,
    status: 0,
    report_images: [],
    user: {
      id: 0,
      name: '',
      gender: 0,
      birth: '',
      pref: 0,
      src: '',
      thumb: ''
    },
    followers_count: 0,
    file: null
  }
  reports = {}
  tags = {}

  get getReport (): ReportModel {
    return this.report
  }

  get getReports (): Object {
    return this.reports
  }

  get getTags (): Object {
    return this.tags
  }

  @Mutation
  setReport (report: ReportModel) {
    this.report = report
  }

  @Mutation
  setReports (reports: Object) {
    this.reports = reports
  }

  @Mutation
  setTags (tags: Object) {
    this.tags = tags
  }

  @Action({ rawError: true })
  async loadReport (id: number) {
    const report = await this.$axios.$get(`/comedy/reports/${id}`)

    this.setReport(report.data)
  }

  @Action({ rawError: true })
  async loadReports (params: {page: number, per_page: number, s: string} = { page: 1, per_page: 20, s: '' }) {
    const reports = await this.$axios.$get('/comedy/reports', {
      params: {
        page: params.page,
        per_page: params.per_page,
        s: params.s
      }
    })

    this.setReports(reports)
  }

  @Action({ rawError: true })
  async loadReportsByUser (name: string, params: {page: number, per_page: number} = { page: 1, per_page: 20 }) {
    const reports = await this.$axios.$get(`/users/${encodeURI(name)}/reports`, {
      params: {
        page: params.page,
        per_page: params.per_page
      }
    })

    this.setReports(reports)
  }

  @Action({ rawError: true })
  async loadReportsByFollower (name: string, params: {page: number, per_page: number} = { page: 1, per_page: 20 }) {
    const reports = await this.$axios.$get(`/users/${encodeURI(name)}/follow_reports`, {
      params: {
        page: params.page,
        per_page: params.per_page
      }
    })

    this.setReports(reports)
  }

  @Action({ rawError: true })
  async loadReportsByReportTag (name: string, params: {page: number, per_page: number} = { page: 1, per_page: 20 }) {
    const reports = await this.$axios.$get(`/comedy/report_tags/${encodeURI(name)}/reports`, {
      params: {
        page: params.page,
        per_page: params.per_page
      }
    })

    this.setReports(reports)
  }

  @Action({ rawError: true })
  async loadReportsByDate (date: string) {
    const tags = await this.$axios.$get(`/comedy/reports/date/${date}`)

    this.setTags(tags.data)
  }

  @Action({ rawError: true })
  async deleteReport (params: {report: {id: number}}) {
    await this.$axios.$post(
      `/admin/reports/${params.report.id}`,
      { _method: 'DELETE' }
    )
  }

  @Action({ rawError: true })
  async addReport (form: Object) {
    await this.$axios.$post(
      '/admin/reports',
      form,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    )
  }

  @Action({ rawError: true })
  async updateReport (id: number, form: Object) {
    await this.$axios.$post(
      `/admin/reports/${id}`,
      form,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    )
  }
}
