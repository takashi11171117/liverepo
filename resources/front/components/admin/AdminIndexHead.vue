<template>
    <div style="margin-bottom: 20px;">
        <h1 class="title">メンバー一覧</h1>
        <b-field>
            <b-input placeholder="検索する"
                     id="search"
                     icon="magnify"
                     :value="search"
                     @change.native="onSearch($event)">
            </b-input>
            <p class="control">
                <button id="search-button" class="button is-primary">検索</button>
            </p>
        </b-field>

        <b-field grouped group-multiline>
            <b-select id="per-page" :value="perPage" @change.native="changePerPage($event)">
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="250">250</option>
            </b-select>

            <p class="control">
                <n-link id="new" :to="{ path: '/admin/admin/new' }" class="button is-info">新規追加</n-link>
            </p>
        </b-field>
    </div>
</template>

<script>
  import {mapGetters, mapMutations} from 'vuex'

  export default {
    data () {
      return {
        query: this.$route.query,
      }
    },

    computed: {
      ...mapGetters(
        {
          page: 'admin-index/page',
          perPage: 'admin-index/perPage',
          search: 'admin-index/search',
        }
      )
    },

    methods: {
      onSearch(event) {
        this.UPDATE_INPUT({'search': event.target.value});
        this.$router.push({
          path: '/admin',
          query: {
            page: this.page,
            per_page: this.perPage,
            s: event.target.value,
          }
        });
      },
      changePerPage(event) {
        this.UPDATE_INPUT({'perPage': event.target.value});
        this.$router.push({
          path: '/admin',
          query: {
            page: this.page,
            per_page: event.target.value,
            s: this.search,
          }
        });
      },
      ...mapMutations('admin-index', [
        'UPDATE_INPUT',
      ]),
    }
  }
</script>