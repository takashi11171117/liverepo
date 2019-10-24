<template>
  <section class="container">
    <div style="margin-bottom: 20px;">
      <h1 class="title">
        レポート一覧
      </h1>
      <b-field>
        <b-input
          id="search"
          placeholder="検索する"
          icon="magnify"
          :value="search"
          @change.native="onSearch($event)"
        />
        <p class="control">
          <button id="search-button" class="button is-primary">
            検索
          </button>
        </p>
      </b-field>

      <b-field grouped group-multiline>
        <b-select id="per-page" :value="perPage" @change.native="changePerPage($event)">
          <option value="20">
            20
          </option>
          <option value="30">
            30
          </option>
          <option value="50">
            50
          </option>
          <option value="100">
            100
          </option>
          <option value="250">
            250
          </option>
        </b-select>

        <p class="control">
          <n-link id="new" :to="{ name: 'admin-reports-new' }" class="button is-info">
            新規追加
          </n-link>
        </p>
      </b-field>
    </div>
    <div>
      <b-table
        v-if="reports !== null || Object.keys(reports.data).length > 0"
        :data="reports.data"
        :checked-rows.sync="checkedRows"
        :bordered="true"
        :striped="true"
        :hoverable="true"
        checkable
      >
        <template slot-scope="props">
          <b-table-column field="id" label="ID" width="40" numeric>
            {{ props.row.id }}
          </b-table-column>

          <b-table-column field="title" label="タイトル">
            {{ $truncate(props.row.title, 25) }}
          </b-table-column>

          <b-table-column field="status" label="ステータス">
            {{ $data.reportStatus[props.row.status] }}
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
              <n-link :to="{ name: 'admin-reports-edit-id', params: {id: props.row.id} }" class="button is-small is-light">
                <b-icon icon="lead-pencil" size="is-small" />
              </n-link>
              <button
                :id="`delete${ props.row.id }`"
                class="button is-small is-danger"
                @click="deleteReport({admin: props.row, query: $route.query})"
              >
                <b-icon icon="delete" size="is-small" />
              </button>
            </div>
          </b-table-column>
        </template>
      </b-table>
      <p v-else-if="reports !== null || Object.keys(reports.data).length === 0" class="no-data">
        データがありません。
      </p>
      <Pagination
        v-if="Object.keys(reports.data).length > 0"
        current_path="/admin/reports"
        :pagination="reports.meta"
      />
      <b-loading :active.sync="isLoading" />
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'
import { ReportStore, ReportIndexStore } from '@/store'
import Pagination from '@/components/Pagination.vue'

@Component({
  components: {
    Pagination
  },
  layout: 'admin',
  watchQuery: ['page', 'per_page', 's'],
  middleware: ['redirectIfAdminGuest']
})
export default class Reports extends Vue {
  isLoading = false
  checkedRows = []

  get search () {
    return ReportIndexStore.getSearch
  }

  get page () {
    return ReportIndexStore.getPage
  }

  get perPage () {
    return ReportIndexStore.getPerPage
  }

  get reports () {
    return ReportStore.getReports
  }

  async fetch (ctx: Context) {
    this.isLoading = true
    await ReportStore.loadReports({
      page: ctx.app.context.query.page,
      per_page: ctx.app.context.query.per_page,
      s: ctx.app.context.query.s
    })
    this.isLoading = false
  }

  onSearch (event: Event) {
    if (event.target instanceof HTMLInputElement) {
      ReportIndexStore.setSearch(event.target.value);
      (this as any).$router.push({
        path: '/admin/reports',
        query: {
          page: this.page,
          per_page: this.perPage,
          s: event.target.value
        }
      })
    }
  }

  changePerPage (event: Event) {
    if (event.target instanceof HTMLInputElement) {
      ReportIndexStore.setPerPage(parseInt(event.target.value));
      (this as any).$router.push({
        path: '/admin/reports',
        query: {
          page: this.page,
          per_page: parseInt(event.target.value),
          s: this.search
        }
      })
    }
  }

  async deleteAdmin (params: {report: {id: number}, query: {page: number, perPage: number, s: string}}) {
    if (confirm('削除してもよろしいですか。')) {
      await ReportStore.deleteReport({ report: params.report })
      await ReportStore.loadReports({
        page: params.query.page,
        per_page: params.query.perPage,
        s: params.query.s
      })
      this.isLoading = false
    }
  }
}
</script>
