import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'services/oauth' })
export default class Oauth extends VuexModule {
  redirectUrl = ''
  callbackData = {}

  get getRedirectUrl (): string {
    return this.redirectUrl
  }

  get getCallbackData (): Object {
    return this.callbackData
  }

  @Mutation
  setRedirectUrl (redirectUrl: string) {
    this.redirectUrl = redirectUrl
  }

  @Mutation
  setCallbackData (callbackData: Object) {
    this.callbackData = callbackData
  }

  @Action({ rawError: true })
  async loadRedirectUrl () {
    const res = await this.$axios.$get('/oauth/twitter/redirect')

    this.setRedirectUrl(res.redirect_url)
  }

  @Action({ rawError: true })
  async loadCallbackData (query: Object) {
    const res = await this.$axios.$get(
      '/oauth/twitter/callback',
      {
        params: query
      }
    )

    this.setCallbackData(res)
  }
}
