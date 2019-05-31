import { Snackbar } from 'buefy/dist/components/snackbar'

export const state = () => ({
  title: '',
  content: '',
  status: '0',
  rating: '1',
  report_images: [],
  file: null,
  error: {},
});

export const getters = {
  title: state => state.title,
  content: state => state.content,
  status: state => state.status,
  rating: state => state.rating,
  report_images: state => state.report_images,
  file: state => state.file,
  error: state => state.error,
};

export const mutations = {
  UPDATE_FORM(state, payload) {
    state.title = payload.title;
    state.content = payload.content;
    state.status = payload.status;
    state.rating = payload.rating;
    state.report_images = payload.report_images;
    state.file = payload.file;
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
        let report_images = res.report_images.map(
          x => {
            return {
              thumb: process.env.imageUrl + 'report_images/thumb-' + x.path,
              src: process.env.imageUrl + 'report_images/' + x.path,
            }
          }
        );
        console.log(report_images);
        commit('UPDATE_FORM', {
          title: res.title,
          content: res.content,
          status: res.status,
          rating: res.rating,
          report_images: report_images,
        });
      }).catch((error) => {
        console.log(error);
        this.$router.push({ path: '/admin/login' })
      })
  },

  async updateEachData({commit, state}, {id}) {
    if (confirm('更新してもよろしいですか？')) {
      let formData = new FormData;
      formData.append('title', state.title);
      formData.append('content', state.content);
      formData.append('status', state.status);
      formData.append('rating', state.rating);
      formData.append('images[]', state.file);
      formData.append('_method', 'PUT');
      await this.$axios.$post(
        `/admin/report/${id}/update`,
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then((data) => {
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