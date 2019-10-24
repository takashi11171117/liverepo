import { PaginationMeta } from '@/src/models/Pagination'

export interface Admin {
  id: number
  name: string
  email: string
  password: string
  created_at: string
  updated_ut: string
}

export interface Admins {
  data: Admin[],
  meta: PaginationMeta
}
