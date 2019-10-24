import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'
import { Admins, Admin as AdminModel } from '@/src/models/Admin'

const initAdmins: Admins = {
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

@Module({ stateFactory: true, namespaced: true, name: 'repos/admin' })
export default class Admin extends VuexModule {
  admins = initAdmins
  admin: AdminModel = {
    id: 0,
    name: '',
    email: '',
    password: '',
    created_at: '',
    updated_ut: ''
  }

  get getAdmins (): Admins {
    return this.admins
  }

  get getAdmin (): AdminModel {
    return this.admin
  }

  @Mutation
  setAdmins (admins: Admins) {
    this.admins = admins
  }

  @Mutation
  setAdmin (admin: AdminModel) {
    this.admin = admin
  }

  @Action({ rawError: true })
  async loadAdmins (params: {page: number, per_page: number, s: string} = { page: 1, per_page: 20, s: '' }) {
    const admins = await this.$axios.$get('/admin/admins', {
      params: {
        page: params.page,
        per_page: params.per_page,
        s: params.s
      }
    })

    this.setAdmins(admins)
  }

  @Action({ rawError: true })
  async loadAdmin (id: number) {
    const admin = await this.$axios.$get(`/admin/admins/${id}`)

    this.setAdmin(admin.data)
  }

  @Action({ rawError: true })
  async deleteAdmin (params: {admin: {id: number}}) {
    await this.$axios.$post(
      `/admin/admins/${params.admin.id}`,
      { _method: 'DELETE' }
    )
  }

  @Action({ rawError: true })
  async addAdmin (params: {name: string, email: string, password: string, password_confirmation: string}) {
    await this.$axios.$post(
      `/admin/admins`,
      {
        name: params.name,
        email: params.email,
        password: params.password,
        password_confirmation: params.password_confirmation
      }
    )
  }

  @Action({ rawError: true })
  async updateAdmin (params: {id: number, name: string, email: string, password: string, password_confirmation: string}) {
    await this.$axios.$post(
      `/admin/admins/${params.id}`,
      {
        _method: 'PUT',
        name: params.name,
        email: params.email,
        password: params.password,
        password_confirmation: params.password_confirmation
      }
    )
  }
}
