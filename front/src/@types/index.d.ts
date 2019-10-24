import { Context } from '@nuxt/types'

export interface nuxtContext extends Context {
  params: { [key: string]: any }
}
