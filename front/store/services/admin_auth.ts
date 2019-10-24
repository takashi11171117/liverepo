import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'services/admin_auth' })
export default class AdminAuth extends VuexModule {
  token = ''
  admin = {}

  get getToken (): string {
    return this.token
  }

  get getAdmin (): Object {
    return this.admin
  }

  get getCheck (): Object {
    return Object.keys(this.admin).length !== 0
  }

  @Mutation
  setToken (token: string) {
    this.token = token
  }

  @Mutation
  fetch_admin_success (admin: Object) {
    this.admin = admin
  }

  @Mutation
  setLogout () {
    this.token = ''
    this.admin = {}
  }

  @Action({ rawError: true })
  saveToken (token: string) {
    this.$cookies.set('token', token)
    this.setToken(token)
  }

  @Action({ rawError: true })
  fetchAdmin (admin: Object) {
    this.$cookies.set('admin', admin)
    this.fetch_admin_success(admin)
  }

  @Action({ rawError: true })
  updateAdmin (admin: Object) {
    this.fetch_admin_success(admin)
  }

  @Action({ rawError: true })
  logout () {
    this.$cookies.remove('token')
    this.$cookies.remove('admin')

    this.setLogout()
  }

  @Action({ rawError: true })
  serverInit () {
    const token = this.$cookies.get('token')
    const admin = this.$cookies.get('admin')
    if (token && admin) {
      this.setToken(token)
      this.fetch_admin_success(admin)
    }
  }

  @Action({ rawError: true })
  clientInit () {
    const token = this.$cookies.get('token')
    const admin = this.$cookies.get('admin')
    if (token && admin) {
      this.setToken(token)
      this.fetch_admin_success(admin)
    }
  }

  @Action({ rawError: true })
  async login (params: {email: string, password: string}): Promise<any> {
    const data = await this.$axios.$post('/auth/admin', {
      email: params.email,
      password: params.password
    })

    return data
  }
}
