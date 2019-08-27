<template>
    <div class="columns">
        <aside
                class="column is-narrow-desktop is-narrow-tablet"
        >
            <Calendar />
        </aside>
        <main class="column">
            <div class="columns is-mobile is-tablet is-multiline">
                <div v-if="$isset(reports.data)" v-for="report in reports.data"
                     class="column is-12-mobile is-6-tablet is-6-desktop">
                    <ReportIndexCard :report="report"/>
                </div>
            </div>
            <Pagination
                    current_path="/"
                    v-bind:pagination="reports"
                    v-if="reports.data !== undefined && Object.keys(reports.data).length > 0"
            />
        </main>
    </div>
</template>
<script>
  import Pagination from '../components/Pagination';
  import ReportIndexCard from '../components/front/ReportIndexCard';
  import Calendar from '../components/front/Calendar';

  export default {
    watchQuery: ['page', 'per_page'],
    components: {
      Pagination,
      ReportIndexCard,
      Calendar
    },
    data() {
      return {
        reports: {},
      }
    },
    async asyncData({$axios, query}) {
      const reports = await $axios.$get('/comedy/reports', {
        params: {
          page: query.page,
          per_page: query.per_page,
        }
      });
      return {reports};
    },
  }
</script>