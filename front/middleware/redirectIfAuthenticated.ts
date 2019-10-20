import { Middleware } from '@nuxt/types'

const redirectIfAuthenticated: Middleware = ({ app, redirect }) => {
  if (app.$auth.loggedIn) {
    return redirect({
      name: 'index'
    })
  }
}

export default redirectIfAuthenticated