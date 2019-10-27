export default interface Report {
  id: number
  title: string
  content: string
  rating: number
  status: number
  report_images: {path: string}[]
  report_tags: {name: string, taxonomy: string}[]
  user: {
    id: number
    name: string
    gender: number
    birth: string
    pref: number
    src: string
    thumb: string
  }
  followers_count: number
  file: File|null
}
