<template>
  <section class="container">
    <div style="margin-bottom: 20px;">
      <h1 class="title">
        メンバー一覧
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
          <n-link id="new" :to="{ name: 'admin-admins-new' }" class="button is-info">
            新規追加
          </n-link>
        </p>
      </b-field>
    </div>
    <div>
      <b-table
        :data="admins.data"
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
            <n-link :to="{ name: 'admin-admins-edit-id', params: {id: props.row.id} }" class="button is-small is-light">
              <b-icon icon="lead-pencil" size="is-small" />
            </n-link>
            <button
              :id="`delete${ props.row.id }`"
              class="button is-small is-danger"
              @click="deleteAdmin({admin: props.row, query: $route.query})"
            >
              <b-icon icon="delete" size="is-small" />
            </button>
          </b-table-column>
        </template>
      </b-table>
      <Pagination
        v-if="Object.keys(admins).length > 0"
        current_path="/admin"
        :pagination="admins.meta"
      />
      <b-loading :active.sync="isLoading" />
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'
import { AdminStore, AdminIndexStore } from '@/store'
import Pagination from '@/components/Pagination.vue'

@Component({
  components: {
    Pagination
  },
  layout: 'admin',
  watchQuery: ['page', 'per_page', 's'],
  middleware: ['redirectIfAdminGuest']
})
export default class Admins extends Vue {
    isLoading = false
    checkedRows = []

    get search () {
      return AdminIndexStore.getSearch
    }

    get page () {
      return AdminIndexStore.getPage
    }

    get perPage () {
      return AdminIndexStore.getPerPage
    }

    get admins () {
      return AdminStore.getAdmins
    }

    async fetch (ctx: Context) {
      this.isLoading = true
      await AdminStore.loadAdmins({
        page: ctx.app.context.query.page,
        per_page: ctx.app.context.query.per_page,
        s: ctx.app.context.query.s
      })
      this.isLoading = false
    }

    onSearch (event: Event) {
      if (event.target instanceof HTMLInputElement) {
        AdminIndexStore.setSearch(event.target.value);
        (this as any).$router.push({
          path: '/admin',
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
        AdminIndexStore.setPerPage(parseInt(event.target.value));
        (this as any).$router.push({
          path: '/admin',
          query: {
            page: this.page,
            per_page: parseInt(event.target.value),
            s: this.search
          }
        })
      }
    }

    async deleteAdmin (params: {admin: {id: number}, query: {page: number, perPage: number, s: string}}) {
      if (confirm('削除してもよろしいですか。')) {
        await AdminStore.deleteAdmin({ admin: params.admin })
        await AdminStore.loadAdmins({
          page: params.query.page,
          per_page: params.query.perPage,
          s: params.query.s
        })
        this.isLoading = false
      }
    }
}
</script>
