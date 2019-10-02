const today = {
  contentStyle: {
    fontWeight: '700',
    color: '#66b3cc',
  },
  dates: new Date(),
};

export const state = () => ({
  attributes: [today]
});

export const getters = {
  attributes: state => state.attributes,
};

export const mutations = {
  UPDATE_ATTRIBUTES(state, payload) {
    let id = 0;
    state.attributes = [
      today,
      ...payload.reportDates.map(reportDate => {
        id++;
        return {
          key: id,
          dates: new Date(reportDate.formatted_published_at),
          order: id,
          dot: {
            backgroundColor: '#ff8080',
          }
        }
      })
    ]
  },
};

export const actions = {
  async fetchAttributes({ commit }, query) {
    const res = await this.$axios.$get(`comedy/reports/month/${query.month}`);
    commit('UPDATE_ATTRIBUTES', {reportDates: res});
  },
};