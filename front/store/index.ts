import { ActionTree, Store } from 'vuex'
import { initialiseStores, AdminAuthStore } from '@/utils/store-accessor'
import { RootState } from '@/store/types'
const initializer = (store: Store<any>) => initialiseStores(store)
export const plugins = [initializer]

export const actions: ActionTree<RootState, RootState> = {
  async nuxtServerInit () {
    await AdminAuthStore.serverInit()
  },

  async nuxtClientInit () {
    await AdminAuthStore.clientInit()
  }
}

export * from '@/utils/store-accessor'
