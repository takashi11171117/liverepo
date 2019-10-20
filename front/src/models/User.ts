import { PaginationMeta } from '@/src/models/Pagination'

export interface User {
  id: number
  name: string
  gender: string
  birth: string
  pref: string
  src: string
  thumb: string
}

export interface Users {
  data: User[],
  meta: PaginationMeta
}
