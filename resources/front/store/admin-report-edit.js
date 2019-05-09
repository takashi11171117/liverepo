import { Snackbar } from 'buefy/dist/components/snackbar'

export const state = () => ({
  title: '',
  content: '',
  status: '0',
  error: {},
});

export const getters = {
  title: state => state.title,
  content: state => state.content,
  status: state => state.status,
  error: state => state.error,
};

export const mutations = {
  UPDATE_FORM(state, payload) {
    state.title = payload.title;
    state.content = payload.content;
    state.status = payload.status;
    state.error = {};
  },
  UPDATE_FORM_ERROR(state, payload) {
    state.error = payload;
  },
  UPDATE_INPUT(state, payload) {
    state = Object.assign(state, payload)
  },
};

export const actions = {
  async fetchEachData({commit}, {id}) {
    await this.$axios.$get(`/admin/report/${id}`)
      .then((res) => {
        commit('UPDATE_FORM', {
          title: res.title,
          content: res.content,
          status: res.status,
        });
      }).catch((error) => {
        console.log(error);
        this.$router.push({ path: '/admin/login' })
      })
  },

  async updateEachData({commit, state}, {id}) {
    if (confirm('更新してもよろしいですか？')) {
      await this.$axios.$post(
        `/admin/report/${id}/update`,
        {
          _method: 'PUT',
          title: state.title,
          content: state.content,
          status: state.status,
        }
      ).then((data) => {
        commit('UPDATE_FORM', {
          title: data.title,
          content: data.content,
          status: data.status,
        });
        Snackbar.open({
          duration: 5000,
          message: 'レポートを更新しました。',
          type: 'is-success',
        });
      }).catch((err) => {
        commit('UPDATE_FORM_ERROR', err.response.data.errors);
      })
    }
  }
};