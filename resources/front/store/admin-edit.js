import { Snackbar } from 'buefy/dist/components/snackbar'

export const state = () => ({
  admin: {},
  name: '',
  email: '',
  password: '',
  passwordConfirm: '',
  error: {},
});

export const getters = {
  admin: state => state.admin,
  name: state => state.name,
  email: state => state.email,
  password: state => state.password,
  passwordConfirm: state => state.passwordConfirm,
  error: state => state.error,
};

export const mutations = {
  UPDATE_ADMIN_FORM(state, payload) {
    state.admin = payload.admin;
    state.name = payload.name;
    state.email = payload.email;
    state.password = '';
    state.passwordConfirm = '';
    state.error = {};
  },
  UPDATE_ADMIN_FORM_ERROR(state, payload) {
    state.error = payload;
  },
  UPDATE_INPUT(state, payload) {
    state = Object.assign(state, payload)
  },
};

export const actions = {
  async fetchAdmin({commit}, {id}) {
    await this.$axios.$get(`admin/admin/${id}`)
      .then(({data}) => {
        commit('UPDATE_ADMIN_FORM', {
          admin: data,
          name: data.name,
          email: data.email,
        });
      }).catch((error) => {
        console.log(error);
        this.$router.push({ path: '/admin/login' })
      })
  },

  async updateAdmin({commit, state}) {
    if (confirm('更新してもよろしいですか？')) {
      await this.$axios.$post(
        `admin/admin/${state.admin.id}/update`,
        {
          _method: 'PUT',
          name: state.name,
          email: state.email,
          password: state.password,
          password_confirmation: state.passwordConfirm,
        }
      ).then(({data}) => {
        commit('UPDATE_ADMIN_FORM', {
          admin: data,
          name: data.name,
          email: data.email,
        });
        Snackbar.open({
          duration: 5000,
          message: '管理者情報を更新しました。',
          type: 'is-success',
        });
      }).catch((err) => {
        commit('UPDATE_ADMIN_FORM_ERROR', err.response.data.errors);
      })
    }
  }
};