import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/follow_report' })
export default class FollowReport extends VuexModule {
  followReports = false

  get getFollowReports (): boolean {
    return this.followReports
  }

  @Mutation
  setFollowReports (followReports: boolean) {
    this.followReports = followReports
  }

  @Action({ rawError: true })
  async loadFollowReports (id: number) {
    const followReports = await this.$axios.$get(`/follow_reports/${id}`)

    this.setFollowReports(followReports.data)
  }
}
