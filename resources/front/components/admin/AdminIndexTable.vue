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

                <b-table-column field="name" label="名前">
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="email" label="メールアドレス">
                    {{ props.row.email }}
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
                    <n-link :to="{ path: `/admin/edit/${props.row.id}` }" class="button is-small is-light">
                        <b-icon icon="lead-pencil" size="is-small"></b-icon>
                    </n-link>
                    <button :id="`delete${ props.row.id }`" class="button is-small is-danger"
                            @click="deleteAdmin({admin: props.row, query: $route.query})">
                        <b-icon icon="delete" size="is-small"></b-icon>
                    </button>
                </b-table-column>
            </template>
        </b-table>
        <p class="no-data" v-else-if="pagination !== null || Object.keys(pagination.data).length === 0">データがありません。</p>
        <Pagination
                current_path="/admin"
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
          isLoading: 'admin-index/isLoading',
          pagination: 'admin-index/pagination',
        }
      )
    },

    methods: {
      ...mapActions('admin-index', ['deleteAdmin'])
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