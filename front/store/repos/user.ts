import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'
import { Users } from '@/src/models/User'

const initUsers: Users = {
  data: [],
  meta: {
    current_page: 1,
    from: 1,
    last_page: 1,
    path: '',
    per_page: 1,
    to: 1,
    total: 1
  }
}

@Module({ stateFactory: true, namespaced: true, name: 'repos/user' })
export default class User extends VuexModule {
  users = initUsers
  user: Object = {}
  followers = initUsers

  get getUsers (): Users {
    return this.users
  }

  get getUser (): Object {
    return this.user
  }

  get getFollowers (): Users {
    return this.followers
  }

  @Mutation
  setUsers (users: Users) {
    this.users = users
  }

  @Mutation
  setUser (user: Object) {
    this.user = user
  }

  @Mutation
  setFollowers (followers: Users) {
    this.followers = followers
  }

  @Action({ rawError: true })
  async loadUsers (params: {page: number, per_page: number} = { page: 1, per_page: 20 }) {
    const users = await this.$axios.$get('/users', {
      params: {
        page: params.page,
        per_page: params.per_page
      }
    })

    this.setUsers(users)
  }

  @Action({ rawError: true })
  async loadUser (name: string) {
    const user = await this.$axios.$get(`/users/${name}`)

    this.setUser(user.data)
  }

  @Action({ rawError: true })
  async loadFollowers (name: string, params: {page: number, per_page: number} = { page: 1, per_page: 20 }) {
    const followers = await this.$axios.$get(`/users/${name}/followers`, {
      params: {
        page: params.page,
        per_page: params.per_page
      }
    })

    this.setFollowers(followers)
  }

  @Action({ rawError: true })
  async updateUserProfile (form: Object) {
    await this.$axios.$post(
      '/users/profile',
      form,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    )
  }
}
