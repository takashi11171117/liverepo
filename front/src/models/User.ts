import { PaginationMeta } from '@/src/models/Pagination'

interface User {
  id: number
  name: string
  gender: string
  birth: string
  pref: string
  src: string
  thumb: string
}

interface Users {
  data: User[],
  meta: PaginationMeta
}

export { User, Users }
