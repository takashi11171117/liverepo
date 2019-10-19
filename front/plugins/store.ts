import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'
import ReportTag from '@/store/repos/report_tag'
import ReportComment from '@/store/repos/report_comment'
import User from '@/store/repos/user'
import FollowUser from '@/store/repos/follow_user'
import FollowReportTag from '@/store/repos/follow_report_tag'
import FollowReport from '@/store/repos/follow_report'
import Calendar from '@/store/services/calendar'

export default (ctx: any) => {
  [
    Report,
    Calendar,
    User,
    FollowUser,
    ReportTag,
    ReportComment,
    FollowReportTag,
    FollowReport
  ]
    .forEach((model: any) => {
      const store = getModule(model, ctx.store)
      store.$axios = ctx.$axios
    })
}
