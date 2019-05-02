export const state = () => ({
  admin: {},
  name: '',
  email: '',
  password: '',
  passwordConfirm: '',
  error: {},
});

export const mutations = {
  updateAdmin(state, payload) {
    state.admin = payload.admin;
    state.name = payload.name;
    state.email = payload.email;
  },
};

export const actions = {
  async fetchAdmin({commit}, id) {
    await $axios.$get(`/admin/admin/${id}`)
      .then((res) => {
        commit('updateAdmin',
          {
            admin: res,
            name: res.name,
            email: res.email,
          });
      })
  }
};