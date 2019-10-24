import { Middleware } from '@nuxt/types'
import { AdminAuthStore } from '@/store'

const redirectIfAdminAuthenticated: Middleware = ({ redirect }) => {
  if (AdminAuthStore.getCheck) {
    return redirect({
      name: 'admin'
    })
  }
}

export default redirectIfAdminAuthenticated
