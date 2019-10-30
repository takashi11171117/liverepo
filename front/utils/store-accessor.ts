import { Store } from 'vuex'
import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'
import ReportTag from '@/store/repos/report_tag'
import ReportComment from '@/store/repos/report_comment'
import User from '@/store/repos/user'
import Admin from '@/store/repos/admin'
import FollowUser from '@/store/repos/follow_user'
import FollowReport from '@/store/repos/follow_report'
import FollowReportTag from '@/store/repos/follow_report_tag'
import Calendar from '@/store/services/calendar'
import Oauth from '@/store/services/oauth'
import AdminAuth from '@/store/services/admin_auth'
import AdminSidebar from '@/store/ui/admin_sidebar'
import AdminIndex from '@/store/form/admin_index'
import ReportIndex from '@/store/form/report_index'
import ReportEdit from '@/store/form/report_edit'
import AdminEdit from '@/store/form/admin_edit'
import FrontReportPost from '@/store/form/front_report_post'

/* eslint import/no-mutable-exports: 0 */
let ReportStore: Report
let ReportTagStore: ReportTag
let ReportCommentStore: ReportComment
let UserStore: User
let AdminStore: Admin
let CalendarStore: Calendar
let OauthStore: Oauth
let AdminAuthStore: AdminAuth
let FollowUserStore: FollowUser
let FollowReportStore: FollowReport
let FollowReportTagStore: FollowReportTag
let AdminSidebarStore: AdminSidebar
let AdminIndexStore: AdminIndex
let ReportIndexStore: ReportIndex
let ReportEditStore: ReportEdit
let AdminEditStore: AdminEdit
let FrontReportPostStore: FrontReportPost

function initialiseStores (store: Store<any>): void {
  ReportStore = getModule(Report, store)
  ReportTagStore = getModule(ReportTag, store)
  ReportCommentStore = getModule(ReportComment, store)
  CalendarStore = getModule(Calendar, store)
  OauthStore = getModule(Oauth, store)
  AdminAuthStore = getModule(AdminAuth, store)
  UserStore = getModule(User, store)
  AdminStore = getModule(Admin, store)
  FollowUserStore = getModule(FollowUser, store)
  FollowReportStore = getModule(FollowReport, store)
  FollowReportTagStore = getModule(FollowReportTag, store)
  AdminSidebarStore = getModule(AdminSidebar, store)
  AdminIndexStore = getModule(AdminIndex, store)
  ReportIndexStore = getModule(ReportIndex, store)
  ReportEditStore = getModule(ReportEdit, store)
  AdminEditStore = getModule(AdminEdit, store)
  FrontReportPostStore = getModule(FrontReportPost, store)
}

export {
  initialiseStores,
  ReportStore,
  ReportTagStore,
  CalendarStore,
  OauthStore,
  AdminAuthStore,
  AdminSidebarStore,
  UserStore,
  AdminStore,
  AdminIndexStore,
  AdminEditStore,
  ReportIndexStore,
  ReportEditStore,
  FollowUserStore,
  FollowReportStore,
  FollowReportTagStore,
  ReportCommentStore,
  FrontReportPostStore
}
