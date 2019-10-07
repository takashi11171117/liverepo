import Cookies from 'universal-cookie'
let cookies = null

export default ({ $axios, store, redirect, app }) => {
  $axios.defaults.baseURL = process.env.apiUrl
  let arrUrl = []

  // Request interceptor
  $axios.onRequest((request) => {
    if (process.server) {
      request.baseURL = process.env.apiServerUrl
    } else {
      request.baseURL = process.env.apiClientUrl
    }

    const token = store.getters.token

    arrUrl = request.url.split('/')

    if (token && arrUrl[0] === 'admin') {
      request.headers.common.Authorization = `Bearer ${token}`
    } else {
      cookies = new Cookies(request.headers.common.cookie)
      if (cookies.get('auth._token.local')) {
        request.headers.common.Authorization = cookies.get('auth._token.local')
      }
    }

    return request
  })

  // Response interceptor
  $axios.onError((error) => {
    const { status } = error.response || {}

    if (status === 404) {
      if (arrUrl[0] === 'admin') {
        redirect('/admin')
      }
    }

    if (status === 401 && store.getters.check && arrUrl[0] === 'admin') {
      redirect('/admin/logout')
    } else if (status === 401) {
      app.$auth.logout()
    }
  })
}
