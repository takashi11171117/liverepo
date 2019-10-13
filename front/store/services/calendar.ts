import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators'
import axios from 'axios'

const today = {
  contentStyle: {
    fontWeight: '700',
    color: '#66b3cc'
  },
  dates: new Date()
}

@Module({ stateFactory: true, namespaced: true, name: 'services/calendar' })
export default class Calendar extends VuexModule {
  attributes: Array<any> = [today]

  get getAttributes (): Array<any> {
    return this.attributes
  }

  @Mutation
  updateAttributes (reportDates: Array<any>) {
    let id = 0
    this.attributes = [
      today,
      ...reportDates.map((reportDate) => {
        id++
        return {
          key: id,
          dates: new Date(reportDate.formatted_published_at),
          order: id,
          dot: {
            backgroundColor: '#ff8080'
          }
        }
      })
    ]
  }

  @Action({ rawError: true })
  async fetchAttributes (month: string) {
    const res = await axios.get(`http://localhost:8000/comedy/reports/month/${month}`)

    this.updateAttributes(res.data)
  }
}
