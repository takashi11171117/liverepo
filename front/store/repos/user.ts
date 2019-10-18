import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'repos/user' })
export default class User extends VuexModule {
  users: Object = {}
  user: Object = {}

  get getUsers (): Object {
    return this.users
  }

  get getUser (): Object {
    return this.user
  }

  @Mutation
  setUsers (users: Object) {
    this.users = users
  }

  @Mutation
  setUser (user: Object) {
    this.user = user
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
