export const state = () => ({
  pagination: {},
  isLoading: true,
  page: 1,
  perPage: 20,
  search: '',
});

export const getters = {
  pagination: state => state.pagination,
  isLoading: state => state.isLoading,
  page: state => state.page,
  perPage: state => state.perPage,
  search: state => state.search,
};

export const mutations = {
  UPDATE_PAGINATION(state, payload) {
    state.pagination = payload.pagination;
    state.isLoading = payload.isLoading;
    state.page = payload.page;
    state.perPage = payload.perPage;
    state.search = payload.search;
  },
  UPDATE_INPUT(state, payload) {
    state = Object.assign(state, payload)
  },
};

export const actions = {
  async fetchReportPagination({ commit }, query) {
    await this.$axios.$get(`/admin/report`, {
      params: {
        page: query.page,
        per_page: query.per_page,
        s: query.s
      }
    }).then(res => {
      // 2ページ目以降データがなければ1ページ目にリダイレクト
      if (res.current_page > 1 && Object.keys(res.data).length === 0) {
        this.$router.push({
          path: '/admin/report',
          query: {
            page: 1,
            per_page: query.per_page,
            s: query.s,
          }
        });
      }

      let per_page = query.per_page ? query.per_page : 20;

      commit('UPDATE_PAGINATION',
        {
          pagination: res,
          isLoading: false,
          page: query.page,
          perPage: per_page,
          search: query.s
        });
    }).catch((error) => {
      console.log(error);
      this.$router.push({ path: '/admin/login' })
    })
  },

  async deleteReport({ commit }, {admin, query}) {
    if (confirm('削除してもよろしいですか。')) {
      let query_string = '';
      if (query.page) {
        query_string = `${query_string}page=${query.page}`;
      }
      if (query.perPage) {
        query_string = `${query_string}&per_page=${query.perPage}`;
      }
      if (query.s) {
        query_string = `${query_string}&s=${query.s}`;
      }
      if (query_string) {
        query_string = `?${query_string}`;
      }

      await this.$axios.$post(
        `/admin/report/${admin.id}/delete${query_string}`,
        {_method: 'DELETE'}
      ).then((res) => {
        commit('UPDATE_PAGINATION',
          {
            pagination: res,
            isLoading: false,
            page: query.page,
            perPage: query.perPage,
            search: query.s
          }
        );
      });
    }
  },

  async addReport({ commit }, {title, content, status}) {
    await this.$axios.$post(
      '/admin/report/add',
      {title, status, content}
    );
  }
};