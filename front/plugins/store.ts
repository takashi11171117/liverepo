import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'
import User from '@/store/repos/user'
import FollowUser from '@/store/repos/follow_user'
import Calendar from '@/store/services/calendar'

export default (ctx: any) => {
  [Report, Calendar, User, FollowUser]
    .forEach((model: any) => {
      const store = getModule(model, ctx.store)
      store.$axios = ctx.$axios
    })
}
