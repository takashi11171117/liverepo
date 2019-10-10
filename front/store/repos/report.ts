import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'
import axios from 'axios'

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
  async loadReports () {
    const reports = await axios.get('http://localhost:8000/comedy/reports', {
      params: {
        page: 1,
        per_page: 10
      }
    })

    this.setReports(reports.data)
  }
}
