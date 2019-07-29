import { Snackbar } from 'buefy/dist/components/snackbar'

export const state = () => ({
  title: '',
  content: '',
  status: '0',
  rating: '1',
  report_images: [],
  report_tags: [],
  file: null,
  error: {},
});

export const getters = {
  title: state => state.title,
  content: state => state.content,
  status: state => state.status,
  rating: state => state.rating,
  report_images: state => state.report_images,
  report_tags: state => state.report_tags,
  file: state => state.file,
  error: state => state.error,
};

export const mutations = {
  UPDATE_FORM(state, payload) {
    state = Object.assign(state, payload);
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
    await this.$axios.$get(`admin/reports/${id}`)
      .then(({data}) => {
        let args = {
          title: data.title,
          content: data.content,
          status: data.status,
          rating: data.rating,
          report_images: data.report_images,
        };

        if (data.report_tags !== undefined) {
          args['report_tags'] = data.report_tags.map((tag) => {
            return {text: tag}
          });
        } else {
          args['report_tags'] = [];
        }

        commit('UPDATE_FORM', args);
      })
  },

  async updateEachData({commit, state}, {id}) {
    if (confirm('更新してもよろしいですか？')) {
      let formData = new FormData;
      let report_tags = state.report_tags.map((tag) => {
        return tag.text;
      });
      formData.append('title', state.title);
      formData.append('content', state.content);
      formData.append('status', state.status);
      formData.append('rating', state.rating);
      if (state.file !== undefined && state.file !== null) {
        formData.append('images[]', state.file);
      }
      formData.append('tags', report_tags);
      formData.append('_method', 'PUT');
      await this.$axios.$post(
        `admin/reports/${id}`,
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then(({data}) => {
        commit('UPDATE_FORM', {
          title: data.title,
          content: data.content,
          status: data.status,
          rating: data.rating,
          file: data.file,
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