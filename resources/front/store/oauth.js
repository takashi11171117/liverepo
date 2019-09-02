import Cookies from "../utils/cookie"

const inBrowser = typeof window !== 'undefined';

export const state = () => {
  return {
    user: null,
    loggedIn: false,
    token: null
  }
};

export const getters = {};

export const mutations = {
  setUser (state, { user }) {
    state.user = user;
    state.loggedIn = Boolean(user);
  },

  setToken (state, { token }) {
    state.token = token;
  }
};

export const actions = {
  nuxtServerInit ({ dispatch, state, commit }, { error }) {
    const token = this.$cookies.cookies.token;

    if (!token) {
      return Promise.resolve()
    }

    return dispatch('fetchUserByAccessToken', { token }).catch(e => {
      return dispatch('logout').catch(e => {
        error({ message: e.message, statusCode: e.statusCode })
      })
    })
  },

  setToken ({commit}, {token}) {
    commit('setToken', { token });

    if (inBrowser) {
      if (token) {
        Cookies().set('token', token, { expires: 30 });
      } else {
        Cookies().remove('token');
      }
    }
  },

  setOauthInfo ({commit}, {user, token}) {
    commit('setUser', { user });
    dispatch('setToken', { token })
  },

  fetchUserByPasswordGrant ({ commit, dispatch }, { email, password }) {
    const params = {
      grant_type: 'password',
      client_id: process.env.clientId,
      client_secret: process.env.clientSecret,
      username: email,
      password: password,
      scope: '*'
    };

    return this.$axios.$post('/oauth/token', params).then(data => {
      return dispatch('fetchUserByAccessToken', { token: data.access_token })
        .catch(e => Promise.reject(e))
    })
  },

  fetchUserByAccessToken ({ commit, dispatch }, { token }) {
    dispatch('setToken', { token });

    return this.$axios.$get('/auth/me').then(user => {
      commit('setUser', { user });
    })
  },

  logout ({ commit }) {
    commit('setUser', { user: null });

    // Revoke access token
    return this.$axios.delete('/oauth/token/destroy').then(() => {
      dispatch('setToken', { token: null })
    }).catch(e => {
      dispatch('setToken', { token: null })
    })
  }
};