import Cookies from "js-cookie"
import {cookieFromRequest} from '../utils'

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
  saveToken({commit}, {token, remember}) {
    Cookies.set('token', token, {expires: remember ? 365 : null});
    commit('SET_TOKEN', token);
  },
  async fetchAdmin({commit}, {admin}) {
    Cookies.set('admin', admin, {expires: 365});
    commit('FETCH_ADMIN_SUCCESS', admin);
  },
  updateAdmin({commit}, payload) {
    commit('UPDATE_ADMIN', payload)
  },
  logout({commit}) {
    Cookies.remove('token');
    Cookies.remove('admin');

    commit('LOGOUT');
    this.$router.push('/admin/login')
  },
  nuxtServerInit({state, commit}, {req}) {
    const token = cookieFromRequest(req, 'token');
    const cookie_admin = cookieFromRequest(req, 'admin');
    let admin = undefined;
    if (cookie_admin) {
      admin = JSON.parse(decodeURIComponent(cookie_admin));
    }
    if (token && admin) {
      commit('SET_TOKEN', token);
      commit('FETCH_ADMIN_SUCCESS', admin);
    }
  },
  nuxtClientInit({ commit }) {
    const token = Cookies.get('token');
    let admin = undefined;
    if (Cookies.get('admin')) {
      admin = JSON.parse(decodeURIComponent(Cookies.get('admin')));
    }
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
