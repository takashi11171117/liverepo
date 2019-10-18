import { Store } from 'vuex'
import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'
import User from '@/store/repos/user'
import FollowUser from '@/store/repos/follow_user'
import Calendar from '@/store/services/calendar'

/* eslint import/no-mutable-exports: 0 */
let ReportStore: Report
let UserStore: User
let CalendarStore: Calendar
let FollowUserStore: FollowUser

function initialiseStores (store: Store<any>): void {
  ReportStore = getModule(Report, store)
  CalendarStore = getModule(Calendar, store)
  UserStore = getModule(User, store)
  FollowUserStore = getModule(FollowUser, store)
}

export { initialiseStores, ReportStore, CalendarStore, UserStore, FollowUserStore }
