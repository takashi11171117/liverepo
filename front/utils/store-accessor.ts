import { Store } from 'vuex'
import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'
import ReportTag from '@/store/repos/report_tag'
import ReportComment from '@/store/repos/report_comment'
import User from '@/store/repos/user'
import FollowUser from '@/store/repos/follow_user'
import FollowReport from '@/store/repos/follow_report'
import FollowReportTag from '@/store/repos/follow_report_tag'
import Calendar from '@/store/services/calendar'

/* eslint import/no-mutable-exports: 0 */
let ReportStore: Report
let ReportTagStore: ReportTag
let ReportCommentStore: ReportComment
let UserStore: User
let CalendarStore: Calendar
let FollowUserStore: FollowUser
let FollowReportStore: FollowReport
let FollowReportTagStore: FollowReportTag

function initialiseStores (store: Store<any>): void {
  ReportStore = getModule(Report, store)
  ReportTagStore = getModule(ReportTag, store)
  ReportCommentStore = getModule(ReportComment, store)
  CalendarStore = getModule(Calendar, store)
  UserStore = getModule(User, store)
  FollowUserStore = getModule(FollowUser, store)
  FollowReportStore = getModule(FollowReport, store)
  FollowReportTagStore = getModule(FollowReportTag, store)
}

export {
  initialiseStores,
  ReportStore,
  ReportTagStore,
  CalendarStore,
  UserStore,
  FollowUserStore,
  FollowReportStore,
  FollowReportTagStore,
  ReportCommentStore
}
