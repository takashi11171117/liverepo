import { Middleware } from '@nuxt/types'

const redirectIfGuest: Middleware = ({ app, redirect, route }) => {
  if (!app.$auth.loggedIn) {
    return redirect({
      name: 'auth-login',
      query: {
        redirect: route.fullPath
      }
    })
  }
}

export default redirectIfGuest