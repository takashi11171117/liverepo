<template>
  <nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
    <n-link id="previous-page" :to="{ path: current_path, query: PgData.previousLinkQuery }" class="pagination-previous" :class="!PgData.isPrevious ? 'disabled' : ''" :disabled="!PgData.isPrevious">
      &lt; 前へ
    </n-link>
    <n-link id="next-page" :to="{ path: current_path, query: PgData.nextLinkQuery }" class="pagination-next" :class="!PgData.isNext ? 'disabled' : ''" :disabled="!PgData.isNext">
      次へ &gt;
    </n-link>
    <ul class="pagination-list">
      <li v-if="PgData.isFirst">
        <n-link id="first-page" :to="{ path: current_path, query: PgData.firstLinkQuery }" class="pagination-link" :aria-label="`Goto page 1`" />
      </li>
      <li v-if="PgData.isFirst">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
      <li v-if="PgData.isPrevious">
        <n-link id="before-page" :to="{ path: current_path, query: PgData.previousLinkQuery }" class="pagination-link" :aria-label="`Goto page ${pagination.current_page - 1}`">
          {{ pagination.current_page - 1 }}
        </n-link>
      </li>
      <li>
        <n-link :to="{ path: current_path, query: PgData.currentLinkQuery }" class="pagination-link is-current" :aria-label="`Page ${pagination.current_page}`" aria-current="page">
          {{ pagination.current_page }}
        </n-link>
      </li>
      <li v-if="PgData.isNext">
        <n-link id="after-page" :to="{ path: current_path, query: PgData.nextLinkQuery }" class="pagination-link" :aria-label="`Goto page ${pagination.current_page + 1}`">
          {{ pagination.current_page + 1 }}
        </n-link>
      </li>
      <li v-if="PgData.isLast">
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
      <li v-if="PgData.isLast">
        <n-link id="last-page" :to="{ path: current_path, query: PgData.lastLinkQuery }" class="pagination-link" :aria-label="`Goto page ${pagination.last_page}`">
          {{ pagination.last_page }}
        </n-link>
      </li>
    </ul>
  </nav>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import { PaginationMeta } from '@/src/models/Pagination'

@Component({})
export default class Pagination extends Vue {
  @Prop({ default: '' })
  current_path!: string

  @Prop({ default: {} })
  pagination!: PaginationMeta

  get PgData (): Object {
    return {
      isPrevious: this.pagination.current_page !== 1,
      isNext: this.pagination.current_page !== this.pagination.last_page,
      isFirst: this.pagination.current_page > 2,
      isLast: this.pagination.current_page < this.pagination.last_page - 1,
      firstLinkQuery: { page: 1, per_page: this.pagination.per_page, s: (this as any).$route.query.s },
      previousLinkQuery: { page: this.pagination.current_page - 1, per_page: this.pagination.per_page, s: (this as any).$route.query.s },
      nextLinkQuery: { page: this.pagination.current_page + 1, per_page: this.pagination.per_page, s: (this as any).$route.query.s },
      lastLinkQuery: { page: this.pagination.last_page, per_page: this.pagination.per_page, s: (this as any).$route.query.s },
      currentLinkQuery: { page: this.pagination.current_page, per_page: this.pagination.per_page, s: (this as any).$route.query.s }
    }
  }
}
</script>

<style lang="sass" scoped>
.pagination
    margin-top: 20px

.pagination-next,
.pagination-link:not(.is-current)
    background-color: #fff
.disabled
  pointer-events: none
</style>
