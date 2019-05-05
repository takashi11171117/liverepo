<template>
    <nav v-if="pagination.data.length > 0" class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">
        <n-link id="previous-page" :to="{ path: current_path, query: previousLinkQuery }" class="pagination-previous" v-bind:disabled="!isPrevious">Previous</n-link>
        <n-link id="next-page" :to="{ path: current_path, query: nextLinkQuery }" class="pagination-next" v-bind:disabled="!isNext">Next page</n-link>
        <ul class="pagination-list">
            <li v-if="isFirst">
                <n-link id="first-page" :to="{ path: current_path, query: firstLinkQuery }" class="pagination-link" :aria-label="`Goto page 1`">1</n-link>
            </li>
            <li v-if="isFirst">
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
            <li v-if="isPrevious">
                <n-link id="before-page" :to="{ path: current_path, query: previousLinkQuery }" class="pagination-link" :aria-label="`Goto page ${pagination.current_page - 1}`">{{pagination.current_page - 1}}</n-link>
            </li>
            <li>
                <n-link :to="{ path: current_path, query: currentLinkQuery }" class="pagination-link is-current" :aria-label="`Page ${pagination.current_page}`" aria-current="page">{{pagination.current_page}}</n-link>
            </li>
            <li v-if="isNext">
                <n-link id="after-page" :to="{ path: current_path, query: nextLinkQuery }" class="pagination-link" :aria-label="`Goto page ${pagination.current_page + 1}`">{{pagination.current_page + 1}}</n-link>
            </li>
            <li v-if="isLast">
                <span class="pagination-ellipsis">&hellip;</span>
            </li>
            <li v-if="isLast">
                <n-link id="last-page" :to="{ path: current_path, query: lastLinkQuery }" class="pagination-link" :aria-label="`Goto page ${pagination.last_page}`">{{pagination.last_page}}</n-link>
            </li>
        </ul>
    </nav>
</template>

<script>
  export default {
    props: {
      current_path: String,
      pagination: Object,
    },

    data() {
      let query =  this.$route.query;
      return {
        isPrevious: this.pagination.current_page !== 1,
        isNext: this.pagination.current_page !== this.pagination.last_page,
        isFirst: this.pagination.current_page > 2,
        isLast: this.pagination.current_page < this.pagination.last_page - 1,
        firstLinkQuery: {  page: 1, per_page: this.pagination.per_page, s: query.s },
        previousLinkQuery: {  page: this.pagination.current_page - 1, per_page: this.pagination.per_page, s: query.s },
        nextLinkQuery: {  page: this.pagination.current_page + 1, per_page: this.pagination.per_page, s: query.s },
        lastLinkQuery: {  page: this.pagination.last_page, per_page: this.pagination.per_page, s: query.s },
        currentLinkQuery: {  page: this.pagination.current_page, per_page: this.pagination.per_page, s: query.s },
      }
    },

    watch: {
      $route: function () {
        let query =  this.$route.query;
        this.isPrevious = this.pagination.current_page !== 1;
        this.isNext = this.pagination.current_page !== this.pagination.last_page;
        this.isFirst = this.pagination.current_page > 2;
        this.isLast = this.pagination.current_page < this.pagination.last_page - 1;
        this.firstLinkQuery = {  page: 1, per_page: this.pagination.per_page, s: query.s };
        this.previousLinkQuery = {  page: this.pagination.current_page - 1, per_page: this.pagination.per_page, s: query.s };
        this.nextLinkQuery = {  page: this.pagination.current_page + 1, per_page: this.pagination.per_page, s: query.s };
        this.lastLinkQuery = {  page: this.pagination.last_page, per_page: this.pagination.per_page, s: query.s };
        this.currentLinkQuery = {  page: this.pagination.current_page, per_page: this.pagination.per_page, s: query.s };
      },
    },
  }
</script>

<style scoped>
    .pagination {
        margin-top: 20px;
    }
</style>