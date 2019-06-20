import Cookies from "../utils/cookie"

export const state = () => ({
  device: {
    isMobile: false,
    isTablet: false
  },
  sidebar: {
    opened: false,
    hidden: false
  },
  token: null,
  admin: null,
});

export const mutations = {
  TOGGLE_DEVICE(state, device) {
    state.device.isMobile = device === 'mobile';
    state.device.isTablet = device === 'tablet';
  },

  TOGGLE_SIDEBAR(state, config) {
    if (state.device.isMobile && config.hasOwnProperty('opened')) {
      state.sidebar.opened = config.opened;
    } else {
      state.sidebar.opened = true;
    }

    if (config.hasOwnProperty('hidden')) {
      state.sidebar.hidden = config.hidden;
    }
  },

  SET_TOKEN(state, token) {
    state.token = token;
  },

  FETCH_ADMIN_SUCCESS(state, admin) {
    state.admin = admin;
  },

  LOGOUT(state) {
    state.admin = null;
    state.token = null;
  },

  UPDATE_ADMIN(state, {admin}) {
    state.admin = admin
  },
};

export const getters = {
  admin: state => state.admin,
  token: state => state.token,
  check: state => state.admin !== null,
  sidebar: state => state.sidebar,
  device: state => state.device,
};

export const actions = {
  saveToken({commit}, {token}) {
    Cookies().set('token', token);
    commit('SET_TOKEN', token);
  },
  async fetchAdmin({commit}, {admin}) {
    Cookies().set('admin', admin);
    commit('FETCH_ADMIN_SUCCESS', admin);
  },
  updateAdmin({commit}, payload) {
    commit('UPDATE_ADMIN', payload)
  },
  logout({commit}) {
    Cookies().remove('token');
    Cookies().remove('admin');

    commit('LOGOUT');
    this.$router.push('/admin/login')
  },
  nuxtServerInit({state, commit}, {req}) {
    let cookies = Cookies(req);
    const token = cookies.get('token');
    const admin = cookies.get('admin');
    if (token && admin) {
      commit('SET_TOKEN', token);
      commit('FETCH_ADMIN_SUCCESS', admin);
    }
  },
  nuxtClientInit({ commit }) {
    const token = Cookies().get('token');
    const admin = Cookies().get('admin');
    if (token && admin) {
      commit('SET_TOKEN', token);
      commit('FETCH_ADMIN_SUCCESS', admin);
    }
  },
  toggleSidebar({commit}, config) {
    if (config instanceof Object) {
      commit('TOGGLE_SIDEBAR', config)
    }
  },
  toggleDevice({commit}, device) {
    commit('TOGGLE_DEVICE', device)
  }
};
