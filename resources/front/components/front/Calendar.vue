<template>
    <div class="sidebar" :class='["popover-direction-" + direction]'>
        <no-ssr>
            <vc-calendar
                    @update:fromPage="pageChange"
                    @dayclick="dayClicked"
                    :attributes="attributes"
            >
                <div
                        slot="todoRow"
                        slot-scope="{ customData }"
                        class="todo-row">
                    <div class="todo-content">
                        <input
                                class="todo-input"
                                v-if="customData.id === editId"
                                v-model="customData.description"
                                @keyup.enter="editId = 0"
                                v-focus-select />
                        <span v-else>
                                  <span
                                          :class='[
                                      "todo-description",
                                      { complete: customData.isComplete }]'
                                          @click="toggleTodoComplete(customData)">
                                    {{ customData.description }}
                                  </span>
                                </span>
                    </div>
                    <a @click.prevent="toggleTodoEdit(customData)">
                        <b-icon
                                v-if="editId !== customData.id"
                                icon="pencil"
                                type="is-info"
                                size="is-small">
                        </b-icon>
                        <b-icon v-else
                                icon="check"
                                type="is-success"
                                size="is-small">
                        </b-icon>
                    </a>
                    <a
                            @click.prevent="deleteTodo(customData)"
                            v-if="!editId || editId !== customData.id"
                            class="delete-todo">
                        <b-icon
                                icon="trash"
                                type="is-danger"
                                size="is-small">
                        </b-icon>
                    </a>
                </div>
            </vc-calendar>
        </no-ssr>
    </div>
</template>
<script>
  export default {
    data() {
      return {
        editId: 0,
        direction: '1',
        todos: [
          {
            id: 1,
            description: 'Take Noah to',
            isComplete: false,
            dates: new Date(2019, 7, 15),
          },
          {
            id: 2,
            description: 'Take Noah to',
            dates: new Date(2019, 7, 14),
          },
          {
            id: 3,
            description: 'Take Noah to',
            dates: new Date(2019, 7, 13),
          },
          {
            id: 4,
            description: 'Take Noah to',
            dates: new Date(2019, 7, 12),
          },
          {
            id: 5,
            description: 'Take Noah to',
            dates: new Date(2019, 7, 11),
          },
          {
            id: 6,
            description: 'Take Noah to',
            dates: new Date(2019, 7, 16),
          },
          {
            id: 7,
            description: 'Take Noah to',
            dates: new Date(2019, 7, 17),
          }
        ],
      }
    },
    computed: {
      attributes() {
        return [
          // Today attribute
          {
            contentStyle: {
              fontWeight: '700',
              color: '#66b3cc',
            },
            dates: new Date(),
          },
          // Todo attributes
          ...this.todos.map(todo => ({
            key: todo.id,
            dates: todo.dates,
            customData: todo,
            order: todo.id,
            dot: {
              backgroundColor: '#ff8080',
              opacity: todo.isComplete ? 0.3 : 1,
            },
            popover: {
              slot: 'todoRow',
              visibility: 'focus',
            }
          }))
        ];
      }
    },
    methods: {
      pageChange(obj) {
        console.log(obj);
      },
      dayClicked (day) {
        this.direction = day.weekday
      },
      toggleTodoComplete(todo) {
        todo.isComplete = !todo.isComplete;
      },
      toggleTodoEdit(todo) {
        this.editId = (this.editId === todo.id) ? 0 : todo.id;
      },
      deleteTodo(todo) {
        this.todos = this.todos.filter(t => t !== todo);
      }
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

