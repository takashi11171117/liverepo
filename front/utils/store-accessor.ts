import { Store } from 'vuex'
import { getModule } from 'vuex-module-decorators'
import Report from '@/store/repos/report'

/* eslint import/no-mutable-exports: 0 */
let ReportStore: Report

function initialiseStores (store: Store<any>): void {
  ReportStore = getModule(Report, store)
}

export { initialiseStores, ReportStore }
