import { VuexModule, Module, Mutation } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'form/admin_index' })
export default class AdminIndex extends VuexModule {
  search = ''
  page = 1
  perPage = 20

  get getSearch (): string {
    return this.search
  }

  get getPage (): number {
    return this.page
  }

  get getPerPage (): number {
    return this.perPage
  }

  @Mutation
  setSearch (search: string) {
    this.search = search
  }

  @Mutation
  setPage (page: number) {
    this.page = page
  }

  @Mutation
  setPerPage (perPage: number) {
    this.perPage = perPage
  }
}
