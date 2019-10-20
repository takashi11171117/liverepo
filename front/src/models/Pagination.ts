export interface PaginationMeta {
  current_page: number,
  from: number,
  last_page: number,
  path: string,
  per_page: number,
  to: number,
  total: number
}

export interface PaginationLinks {
  first: string,
  last: string,
  prev: string,
  next: string,
}
