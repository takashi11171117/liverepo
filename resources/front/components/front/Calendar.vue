<template>
    <div class="sidebar" :class='["popover-direction-" + direction]'>
        <no-ssr>
            <vc-calendar
                    @update:fromPage="pageChange"
                    @dayclick="dayClicked"
                    :attributes="attributes"
            >
            </vc-calendar>
        </no-ssr>
    </div>
</template>
<script>
  import { mapGetters, mapActions } from 'vuex';

  export default {
    data() {
      return {
        editId: 0,
        direction: '1',
      }
    },
    computed: {
      ...mapGetters(
        {
          attributes: 'calendar/attributes',
        }
      )
    },
    methods: {
      async pageChange(obj) {
        const month = ("0"+(obj.month)).slice(-2);
        await this.fetchAttributes({month: `${obj.year}-${month}`});
      },
      dayClicked (day) {
        this.direction = day.weekday
      },
      ...mapActions('calendar', [
        'fetchAttributes',
      ]),
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

