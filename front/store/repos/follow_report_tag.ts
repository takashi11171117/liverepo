import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/follow_report_tag' })
export default class FollowReportTag extends VuexModule {
  followReportTags = false

  get getFollowReportTags (): boolean {
    return this.followReportTags
  }

  @Mutation
  setFollowReportTags (followReportTags: boolean) {
    this.followReportTags = followReportTags
  }

  @Action({ rawError: true })
  async loadFollowReportTags (id: number) {
    const followReportTags = await this.$axios.$get(`/follow_report_tags/${id}`)

    this.setFollowReportTags(followReportTags.data)
  }
}
