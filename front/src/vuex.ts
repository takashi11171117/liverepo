import { NuxtAxiosInstance } from '@nuxtjs/axios'

export default interface injectAxios {
  $axios: NuxtAxiosInstance;
}
