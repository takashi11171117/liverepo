export default interface Report {
  id: number
  title: string
  content: string
  rating: number
  report_images: {path: string}[]
  user: {
    id: number
    name: string
    gender: number
    birth: string
    pref: number
    src: string
    thumb: string
  }
}
