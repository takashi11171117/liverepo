import { PaginationMeta } from '@/src/models/Pagination'

export interface User {
  id: number
  name: string
  gender: string
  birth: string
  pref: string
  src: string
  thumb: string
  user_name01: string
  user_name02: string
  description: string
  url: string
  show_mail_flg: string
}

export interface Users {
  data: User[],
  meta: PaginationMeta
}
