import { NuxtAxiosInstance } from '@nuxtjs/axios'

declare module 'vuex-module-decorators' {
  interface VuexModule {
    $axios: NuxtAxiosInstance;
  }
}
