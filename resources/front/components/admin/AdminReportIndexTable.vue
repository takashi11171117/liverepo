<template>
    <div>
        <b-table
                :data="pagination.data"
                :checked-rows.sync="checkedRows"
                :bordered="true"
                :striped="true"
                :hoverable="true"
                checkable
                v-if="pagination !== null || Object.keys(pagination.data).length > 0"
        >
            <template slot-scope="props">
                <b-table-column field="id" label="ID" width="40" numeric>
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column field="title" label="タイトル">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="status" label="ステータス">
                    {{ props.row.status }}
                </b-table-column>

                <b-table-column field="created_at" label="作成日" centered>
                            <span class="tag is-success">
                                {{ new Date(props.row.created_at).toLocaleDateString() }}
                            </span>
                </b-table-column>

                <b-table-column field="updated_at" label="更新日" centered>
                            <span class="tag is-success">
                                {{ new Date(props.row.updated_at).toLocaleDateString() }}
                            </span>
                </b-table-column>

                <b-table-column custom-key="actions">
                    <div style="width: 60px;">
                        <n-link :to="{ path: `/admin/report/edit/${props.row.id}` }" class="button is-small is-light">
                            <b-icon icon="lead-pencil" size="is-small"></b-icon>
                        </n-link>
                        <button :id="`delete${ props.row.id }`" class="button is-small is-danger"
                                @click="deleteReport({admin: props.row, query: $route.query})">
                            <b-icon icon="delete" size="is-small"></b-icon>
                        </button>
                    </div>
                </b-table-column>
            </template>
        </b-table>
        <p class="no-data" v-else-if="pagination !== null || Object.keys(pagination.data).length === 0">データがありません。</p>
        <Pagination
                current_path="/admin/report"
                v-bind:pagination="pagination"
                v-if="Object.keys(pagination).length > 0"
        />
        <b-loading :active.sync="isLoading"></b-loading>
    </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import Pagination from './Pagination'

  export default {
    components: {
      Pagination,
    },

    data() {
      return {
        checkedRows: [],
      }
    },

    computed: {
      ...mapGetters(
        {
          isLoading: 'admin-report-index/isLoading',
          pagination: 'admin-report-index/pagination',
        }
      )
    },

    methods: {
      ...mapActions('admin-report-index', ['deleteReport'])
    }
  }
</script>

<style scoped>
    .no-data {
        background-color: #fff;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>