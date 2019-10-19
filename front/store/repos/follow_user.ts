import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/follow_user' })
export default class FollowUser extends VuexModule {
  followUsers = false

  get getFollowUsers (): boolean {
    return this.followUsers
  }

  @Mutation
  setFollowUsers (followUsers: boolean) {
    this.followUsers = followUsers
  }

  @Action({ rawError: true })
  async loadFollowUsers (id: number) {
    const followUsers = await this.$axios.$get(`/follow_users/${id}`)

    this.setFollowUsers(followUsers.data)
  }
}
