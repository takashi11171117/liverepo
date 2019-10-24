import { NuxtAxiosInstance } from '@nuxtjs/axios'
import { NuxtCookies } from 'cookie-universal-nuxt'

declare module 'vuex-module-decorators' {
  interface VuexModule {
    $axios: NuxtAxiosInstance;
    $cookies: NuxtCookies;
  }
}
