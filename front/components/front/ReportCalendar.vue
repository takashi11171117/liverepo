<template>
  <div class="sidebar" :class="`popover-direction-${direction}`">
    <no-ssr>
      <v-calendar
        :attributes="attributes"
        @update:fromPage="pageChange"
        @dayclick="dayClicked"
      />
    </no-ssr>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'
import { CalendarStore } from '@/store'

@Component({})
export default class ReportCalendar extends Vue {
  public direction = '1'

  get attributes (): Object {
    console.log(CalendarStore.getAttributes)
    return CalendarStore.getAttributes
  }

  public pageChange = async (obj: {year: number, month: number}) => {
    const month = ('0' + (obj.month)).slice(-2)
    await CalendarStore.fetchAttributes(`${obj.year}-${month}`)
  }

  public dayClicked = (day: {year: number, month: number, day: number}, ctx: Context) => {
    const month = ('0' + (day.month)).slice(-2)
    const formattedDay = ('0' + (day.day)).slice(-2)
    ctx.app.$router.replace({
      name: 'comedy-reports-date-date',
      params: {
        date: `${day.year}-${month}-${formattedDay}`
      }
    })
  }
}
</script>

<style lang="sass" scoped>
.sidebar
    &.popover-direction-1 /deep/ .popover-origin
        transform: translateX(-6%)
        .popover-content:after
            left: 5.4%
    &.popover-direction-2 /deep/ .popover-origin
        transform: translateX(-20%)
        .popover-content:after
            left: 19.6%
    &.popover-direction-3 /deep/ .popover-origin
        transform: translateX(-35%)
        .popover-content:after
            left: 34.6%
    &.popover-direction-5 /deep/ .popover-origin
        transform: translateX(-65%)
        .popover-content
            width: 100%
            &:after
                left: 65.3%
    &.popover-direction-6 /deep/ .popover-origin
        transform: translateX(-80%)
        .popover-content:after
            left: 80.3%
    &.popover-direction-7 /deep/ .popover-origin
        transform: translateX(-95%)
        .popover-content:after
            left: 95.4%
</style>
