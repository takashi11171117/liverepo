import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/follow_user' })
export default class FollowUser extends VuexModule {
  followUsers: Object = {}

  get getFollowUsers (): Object {
    return this.followUsers
  }

  @Mutation
  setFollowUsers (followUsers: Object) {
    this.followUsers = followUsers
  }

  @Action({ rawError: true })
  async loadFollowUsers (id: number) {
    const followUsers = await this.$axios.$get(`/follow_users/${id}`)

    this.setFollowUsers(followUsers.data)
  }
}
