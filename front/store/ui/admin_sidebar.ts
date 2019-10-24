import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'

@Module({ stateFactory: true, namespaced: true, name: 'ui/admin_sidebar' })
export default class AdminSidebar extends VuexModule {
  device = {
    isMobile: false,
    isTablet: false
  }
  sidebar = {
    opened: false,
    hidden: false
  }

  get getDevice (): Object {
    return this.device
  }

  get getSidebar (): Object {
    return this.sidebar
  }

  @Mutation
  setDevice (device: string) {
    this.device.isMobile = device === 'mobile'
    this.device.isTablet = device === 'tablet'
  }

  @Mutation
  setSidebar (config: {opened: boolean}) {
    if (this.device.isMobile && config.hasOwnProperty('opened')) {
      this.sidebar.opened = config.opened
    } else {
      this.sidebar.opened = true
    }
  }

  @Action({ rawError: true })
  toggleSidebar (config: {opened: boolean}) {
    this.setSidebar(config)
  }

  @Action({ rawError: true })
  toggleDevice (device: string) {
    this.setDevice(device)
  }
}
