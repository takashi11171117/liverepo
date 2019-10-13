import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'
import Calendar from '@/store/services/calendar'

export default (ctx: any) => {
  const ReportStore = getModule(Report, ctx.store)
  ReportStore.$axios = ctx.$axios
  const CalendarStore = getModule(Calendar, ctx.store)
  CalendarStore.$axios = ctx.$axios
}
