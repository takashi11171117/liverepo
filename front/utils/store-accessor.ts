import { Store } from 'vuex'
import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'
import Calendar from '@/store/services/calendar'

/* eslint import/no-mutable-exports: 0 */
let ReportStore: Report
let CalendarStore: Calendar

function initialiseStores (store: Store<any>): void {
  ReportStore = getModule(Report, store)
  CalendarStore = getModule(Calendar, store)
}

export { initialiseStores, ReportStore, CalendarStore }
